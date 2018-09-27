<?php

namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;

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

            $grant_type = new ClientCredentials($reauth_client, $reauth_config);

            $oauth = new OAuth2Middleware($grant_type);

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
