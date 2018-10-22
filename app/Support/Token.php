<?php

namespace App\Support;

use kamermans\OAuth2\Token\TokenInterface;

class Token implements TokenInterface
{

    /**
     * @var string $token_type
     */
    protected $tokenType;

    /**
     * @var int $expires_at
     */
    protected $expiresAt;

    /**
     * @var string $access_token
     */
    protected $accessToken;

    /**
     * @var string $refreshToken
     */
    protected $refreshToken;

    /**
     * Token constructor.
     * @param string $tokenType
     * @param string $accessToken
     * @param string $refreshToken
     * @param int $expiresIn
     */
    public function __construct($tokenType, $accessToken, $refreshToken, $expiresIn)
    {
        $this->tokenType = (string)$tokenType;
        $this->accessToken = (string)$accessToken;
        $this->refreshToken = (string)$refreshToken;
        $this->expiresAt = time() + (int)$expiresIn;
    }

    /**
     * Get token type
     */
    public function getType()
    {
        return $this->tokenType;
    }

    /**
     * @return string The access token
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string|null The refresh token
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     *
     * @return int The expiration date as a timestamp
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->expiresAt && $this->expiresAt < time();
    }
}
