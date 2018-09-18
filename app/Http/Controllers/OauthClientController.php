<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class OauthClientController extends Controller
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

    public function requestCode()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => env('OAUTH_CLIENT_ID', 'client_id'),
            'redirect_uri' => env('OAUTH_REDIRECT_URI', '#'),
            'scope' => env('OAUTH_SCOPE', ''),
            'state' => csrf_token(),
        ]);
        
        return redirect(env('OAUTH_AUTHORIZE_URI', '') . '?' . $query);
    }

    // perform user authentication
    public function requestToken(Request $request)
    {

        if (!empty($request->get('error'))) {
            return response($request->all());
        }

        # verify the "state" parameter matches this user's session (this is like CSRF - very important!!)
        if (Session()->token() != $request->state)
            return response()->json(['error' => 'Your session has expired.  Please try again.']);

        $http_client = new Client();
        $method = "POST";
        $route = env('OAUTH_TOKEN_URI', '');
        $options = [
            'auth' => [
                env('OAUTH_CLIENT_ID', 'client-id'),
                env('OAUTH_CLIENT_SECRET', 'client-secret')
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => env('OAUTH_REDIRECT_URI', '#')
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
        } catch (RequestException $ex) {
            return response($ex->getResponse()->getBody()->getContents());
        }

    }

}
