<?php

namespace App\Providers;

use App\Support\SessionTokenPersistence;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\NullTokenPersistence;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @link https://github.com/kamermans/guzzle-oauth2-subscriber
         */
        $this->app->singleton('guzzle-client', function () {

            // Authorization client - this is used to request OAuth access tokens
            $reauth_client = new Client([
                // URL for access_token request
                'base_uri' => config('oauth.token_uri'),
            ]);

            $reauth_config = [
                "client_id" => config('oauth.client_id'),
                "client_secret" => config('oauth.client_secret'),
                "scope" => config('oauth.scopes'),
                "state" => time(),
            ];

            // This grant type is used to get a new Access Token and,
            // Refresh Token when no valid Access Token or Refresh Token is available
            $client_grant = new ClientCredentials($reauth_client, $reauth_config);

            // This grant type is used to get a new Access Token and,
            // Refresh Token when only a valid Refresh Token is available
            $refresh_token_grant = new RefreshToken($reauth_client, $reauth_config);

            // Tell the middleware to use both the client and refresh token grants
            $oauth = new OAuth2Middleware($client_grant, $refresh_token_grant);

            // $oauth->setTokenPersistence(new NullTokenPersistence());

            $oauth->setTokenPersistence(new SessionTokenPersistence());

            $stack = HandlerStack::create();

            $stack->push($oauth);

            // This is the normal Guzzle client that you use in your application
            return new Client([
                'auth' => 'oauth',
                'handler' => $stack,
                'base_uri' => config('oauth.api_uri'),
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

        });

        $this->app->singleton('guzzle', function ($app, $parameters) {

            // Password client - this is used to request OAuth access tokens
            $reauth_client = new Client([
                // URL for access_token request
                'base_uri' => config('oauth.token_uri'),
            ]);

            $reauth_config = [
                'client_id' => config('oauth.client_id'),
                'client_secret' => config('oauth.client_secret'),
                // User name password; only available on login
                // The rest of the time use refresh token;
                // If refresh token is expired; user must login afresh.
                'username' => isset($parameters['username']) ? $parameters['username'] : '', // 'jdoe@example.com',
                'password' => isset($parameters['password']) ? $parameters['password'] : '', // 'qwerty',
                // refresh_token will be set when token is created
                'refresh_token' => '',
                'scope' => config('oauth.scopes'),
            ];

            // This grant type is used to get a new Access Token and,
            // Refresh Token when no valid Access Token or Refresh Token is available
            $password_grant = new PasswordCredentials($reauth_client, $reauth_config);

            // This grant type is used to get a new Access Token and,
            // Refresh Token when only a valid Refresh Token is available
            $refresh_token_grant = new RefreshToken($reauth_client, $reauth_config);

            // Tell the middleware to use both the password and refresh token grants
            $oauth = new OAuth2Middleware($password_grant, $refresh_token_grant);

            $oauth->setTokenPersistence(new SessionTokenPersistence());

            $stack = HandlerStack::create();

            $stack->push($oauth);

            // This is the normal Guzzle client that you use in your application
            return new Client([
                'auth' => 'oauth',
                'handler' => $stack,
                'base_uri' => config('oauth.api_uri'),
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

        });
    }
}
