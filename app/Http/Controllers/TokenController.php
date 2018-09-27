<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TokenController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Request for authorization code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestCode()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => env('OAUTH_CLIENT_ID', 'client_id'),
            'redirect_uri' => env('OAUTH_REDIRECT_URI'),
            'scope' => env('OAUTH_SCOPE', ''),
            'state' => csrf_token(),
        ]);

        return redirect(env('OAUTH_AUTHORIZE_URI', '') . '?' . $query);
    }

    /**
     * Exchange code
     * Authorization code for access token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchangeCodeForToken(Request $request)
    {

        if (!empty($request->get('error'))) {
            return response($request->all());
        }

        # verify the "state" parameter matches this user's session (this is like CSRF - very important!!)
        if (Session()->token() != $request->state)
            return response()->json(['error' => 'Your session has expired.  Please try again.']);

        $http_client = new Client();
        $method = "POST";
        $route = env('OAUTH_TOKEN_URI');
        $options = [
            'auth' => [
                env('OAUTH_CLIENT_ID'),
                env('OAUTH_CLIENT_SECRET')
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => env('OAUTH_REDIRECT_URI')
            ],
        ];

        try {

            $response = $http_client->request($method, $route, $options);

            $response_data = json_decode((string)$response->getBody(), true);

            if ($response->getStatusCode() == 200) {

                if (array_key_exists('error', $response_data)) {
                    return response($response_data);
                }

                return $response_data;

            }

            return $response_data;

        } catch (ConnectException $ex) {
            return response()->json(['error' => (string)$ex->getMessage()], 500);
        } catch (ClientException $ex) {
            return response($ex->getResponse()->getBody()->getContents());
        } catch (ServerException $ex) {
            return response($ex->getResponse()->getBody()->getContents());
        }

    }

    /**
     * Request for access token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function token(Request $request)
    {

        $this->validate($request, [
            'grant_type' => ['required', Rule::in(['authorization_code', 'client_credentials', 'password', 'refresh_token',])],
            'code' => 'required_if:grant_type,authorization_code',
            'redirect_uri' => 'nullable|url',
            'refresh_token' => 'required_if:grant_type,refresh_token|size:100',
            'username' => 'required_if:grant_type,password',
            'password' => 'required_if:grant_type,password',
            'scopes' => 'sometimes|array',
        ]);

        switch ($request->grant_type) {
            case "authorization_code":
                $params = [
                    'code' => $request->code,
                    'redirect_uri' => $request->redirect_uri,
                    'scope' => implode(" ", $request->scopes)
                ];
                break;
            case "client_credentials":
                $params = [
                    'scope' => implode(" ", $request->scopes)
                ];
                break;
            case "password":
                $params = [
                    'username' => $request->username,
                    'password' => $request->password,
                    'scope' => implode(" ", $request->scopes)
                ];
                break;
            case "refresh_token":
                $params = [
                    'refresh_token' => $request->refresh_token,
                    'scope' => implode(" ", $request->scopes)
                ];
                break;
            default:
                return response()->json(['error' => ['grant_type' => ['Unknown grant type']]], 422);
        }

        $http = new Client();

        $options = [
            'auth' => [
                env('OAUTH_CLIENT_ID'),
                env('OAUTH_CLIENT_SECRET')
            ],
            'form_params' => $params,
        ];

        $response = $http->post(env('OAUTH_TOKEN_URI'), $options);

        return json_decode((string)$response->getBody(), true);
    }

}
