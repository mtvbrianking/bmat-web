<?php
/**
 * Created by PhpStorm.
 * User: bmatovu
 * Date: 9/28/2018
 * Time: 7:02 PM
 */

namespace App\Support;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Config\Repository as Config;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\TokenInterface;

class SessionTokenPersistence implements TokenPersistenceInterface
{

    /**
     * The configuration repository implementation.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * The name for API token cookies.
     *
     * @var string
     */
    protected $cookie = 'guzzle_token';

    /**
     * Create an API token cookie factory instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(Config $config, Encrypter $encrypter)
    {
        $this->config = $config;
        $this->encrypter = $encrypter;
    }

    /**
     * Restore the token data into the give token.
     *
     * @param TokenInterface $token
     *
     * @return TokenInterface Restored token
     */
    public function restoreToken(TokenInterface $token)
    {
        if(!isset($_COOKIE[$this->cookie])){
            return null;
        }

        $token = $_COOKIE[$this->cookie];

        return JWT::decode($token, $this->encrypter->getKey());
    }

    /**
     * Save the token data.
     *
     * @param TokenInterface $token
     */
    public function saveToken(TokenInterface $token)
    {
        $config = $this->config->get('session');

        $expiration = Carbon::now()->addMinutes($config['lifetime']);

        new Cookie(
            $this->cookie,
            $this->createToken($token),
            $expiration,
            $config['path'],
            $config['domain'],
            $config['secure'],
            true,
            false,
            $config['same_site'] ?? null
        );
    }

    /**
     * Delete the saved token data.
     */
    public function deleteToken()
    {
        if (isset($_COOKIE[$this->cookie])) {
            setcookie($this->cookie, '', time() - 3600, '/');
            unset($_COOKIE[$this->cookie]);
        }
    }

    /**
     * Returns true if a token exists (although it may not be valid)
     *
     * @return bool
     */
    public function hasToken()
    {
        return isset($_COOKIE[$this->cookie]);
    }

    /**
     * Create a new JWT token.
     *
     * @param  TokenInterface $token
     * @return string
     */
    protected function createToken(TokenInterface $token)
    {
        return JWT::encode($token, $this->encrypter->getKey());
    }

}
