<?php

namespace App\Support;

use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\TokenInterface;

class FileTokenPersistence implements TokenPersistenceInterface {

    private $file = "/tmp/token.txt";

    public function saveToken(TokenInterface $token) {
        echo "Saving token: ".var_export($token, true)."\n";
        $value = $token->serialize();
        file_put_contents($this->file, json_encode($value));
    }

    public function restoreToken(TokenInterface $token) {
        $value = @file_get_contents($this->file);
        $value = $value === false? null: $token->unserialize(json_decode($value, true));
        echo "Restoring token: ".var_export($token, true)."\n";
        return $value;
    }

    public function deleteToken() {
        echo "Deleting token\n";
        @unlink($this->file);
    }

    /**
     * Returns true if a token exists (although it may not be valid)
     *
     * @return bool
     */
    public function hasToken()
    {
        // TODO: Implement hasToken() method.
    }
}

