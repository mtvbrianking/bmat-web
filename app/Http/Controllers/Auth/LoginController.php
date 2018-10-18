<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

//        if ($this->attemptRemoteLogin($request)) {
//            return $this->sendLoginResponse($request);
//        }

        // Attempt remote authentication

        $client = app('guzzle');

        $options = [
            'form_params' => [
                'email' => $request->email,
                'password' => $request->password,
            ],
        ];

        try {

            $api_response = $client->post('users/auth', $options);

            $remote_user = json_decode($api_response->getBody(), true);

            $user = $this->syncRemoteUser($remote_user, $request->password);

            return $this->sendLoginResponse($request);

        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $status = $ex->getResponse()->getStatusCode();
            if ($status == 401) {
                Log::error(json_encode([$status => $ex->getMessage()]));
            }
            if ($status == 422) {
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                $response = json_decode($ex->getResponse()->getBody(), true);

                return redirect()->back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors($response['errors']);
            }
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            Log::error(json_encode([$ex->getCode() => $ex->getMessage()]));
            flash("Something went terribly wrong")->warning()->important();
            return redirect()->back();
        }

        // ...

        flash("Request can't be processed...")->warning()->important();
        return redirect()->back();
    }

    /**
     * @param array $r_user
     * @param $secret
     * @return \App\User
     */
    public function syncRemoteUser(array $r_user, $secret)
    {
        // Prevent duplicate user accounts
        User::query()
            ->where(['id' => $r_user['id']])
            ->orWhere(['email' => $r_user['email']])
            ->forceDelete();

        // Mirror user details...
        $user = new User();
        $user->id = $r_user['id'];
        $user->name = $r_user['name'];
        $user->email = $r_user['email'];
        $user->password = Hash::make($secret);
        // $user->email_verified_at = $r_user['email_verified_at'];
        $user->save();

        return $user;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function authenticated(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended($this->redirectPath());
        }
    }

}
