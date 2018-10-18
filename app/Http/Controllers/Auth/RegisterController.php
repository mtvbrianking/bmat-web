<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {

            $client = app('guzzle');

            $options = [
                'form_params' => $request->input(),
            ];

            $api_response = $client->post('users', $options);

            $remote_user = json_decode($api_response->getBody(), true);

            $user = $this->syncRemoteUser($remote_user);

            event(new Registered($user));

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());

        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $status = $ex->getResponse()->getStatusCode();
            if ($status == 401) {
                Log::error(json_encode([$status => $ex->getMessage()]));
                flash("Unauthenticated #401")->warning()->important();
            }
            if ($status == 422) {
                $response = json_decode($ex->getResponse()->getBody(), true);

                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($response['errors']);
            }
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            Log::error(json_encode([$ex->getCode() => $ex->getMessage()]));
            flash("Something went terribly wrong")->warning()->important();
            return redirect()->back();
        }

    }

    /**
     * @param array $r_user
     * @param $secret
     * @return \App\User
     */
    public function syncRemoteUser(array $r_user)
    {
        // Prevent duplicate user accounts
        User::query()
            ->where(['id' => $r_user['id']])
            ->orWhere(['name' => $r_user['name']])
            ->orWhere(['email' => $r_user['email']])
            ->forceDelete();

        // Mirror user details...
        $user = new User();
        $user->id = $r_user['id'];
        $user->name = $r_user['name'];
        $user->email = $r_user['email'];
        $user->password = Hash::make(str_random());
        // $user->email_verified_at = $r_user['email_verified_at'];
        $user->save();

        return $user;
    }

}
