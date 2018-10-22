<?php
/**
 * Created by PhpStorm.
 * User: bmatovu
 * Date: 9/28/2018
 * Time: 7:02 PM
 */

namespace App\Support;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\RawToken;
use kamermans\OAuth2\Token\TokenInterface;

class SessionTokenPersistence implements TokenPersistenceInterface
{

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
     * @param  \Illuminate\Contracts\Encryption\Encrypter $encrypter
     * @return void
     */
    public function __construct()
    {
        $this->encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
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
        $value = @file_get_contents(storage_path('app/token.txt'));
        // $token = new \kamermans\OAuth2\Token\RawToken();
        $value = $value === false ? null : $token->unserialize(json_decode($value, true));
        Log::debug(['restoring' => $token]);

        return $value;

//        if (!isset($_COOKIE[$this->cookie])) {
//            return null;
//        }
//
//        $cookie = Cookie::get($this->cookie);
//
//        return unserialize($cookie);

        // $token_str = JWT::decode($cookie, $this->encrypter->getKey(), ['HS256']);

        // return unserialize($token_str);
    }

    /**
     * Save the token data.
     *
     * @param TokenInterface $token
     */
    public function saveToken(TokenInterface $token)
    {
        Log::debug(['saving' => $token]);
        Storage::disk('local')->put('/token.txt', json_encode($token->serialize()));

//        $config = config('session');
//
//        $expires_in = $config['lifetime'];
//        // $expires_in = $token->getExpiresAt();
//        // $expires_in = max($config['lifetime'], $token->getExpiresAt());
//
//        Cookie::queue(Cookie::make(
//            $this->cookie,
//            serialize($token),
//            // $this->createToken($token),
//            $expires_in,
//            $config['path'],
//            $config['domain'],
//            $config['secure'],
//            true,
//            false,
//            $config['same_site'] ?? null
//        ));
    }

    /**
     * Delete the saved token data.
     */
    public function deleteToken()
    {
        Log::debug(['delete' => storage_path('app/token.txt')]);
        @unlink(storage_path('app/token.txt'));
//        if (isset($_COOKIE[$this->cookie])) {
//            setcookie($this->cookie, '', time() - 3600, '/');
//            unset($_COOKIE[$this->cookie]);
//        }
    }

    /**
     * Returns true if a token exists (although it may not be valid)
     *
     * @return bool
     */
    public function hasToken()
    {
        return file_exists(storage_path('app/token.txt'));
        // return isset($_COOKIE[$this->cookie]);
    }

    /**
     * Create a new JWT token.
     *
     * @param  TokenInterface $token
     * @return string
     */
    protected function createToken(TokenInterface $token)
    {
        return JWT::encode(serialize($token), $this->encrypter->getKey());
    }

}
