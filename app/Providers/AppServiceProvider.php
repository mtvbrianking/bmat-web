<?php

namespace App\Providers;

use App\Support\SessionTokenPersistence;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;
use kamermans\OAuth2\GrantType\ClientCredentials;
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
        $this->app->singleton('guzzle', function () {

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

            // This grant type is used to get a new Access Token and Refresh Token when
            //  no valid Access Token or Refresh Token is available
            $client_grant = new ClientCredentials($reauth_client, $reauth_config);

            // This grant type is used to get a new Access Token and Refresh Token when
            //  only a valid Refresh Token is available
            $refresh_token_grant = new RefreshToken($reauth_client, $reauth_config);

            // Tell the middleware to use both the client and refresh token grants
            $oauth = new OAuth2Middleware($client_grant, $refresh_token_grant);

//            $oauth->setTokenPersistence(new NullTokenPersistence());

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
