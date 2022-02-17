<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use Support\Configuration\Configuration;

class User extends BaseService
{
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';

    private static $currentUserId;

    public function getByEmail($email)
    {
        $parameters = [
            ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    public function getByUserId($userId)
    {
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }

    public function getList()
    {
        return $this->fetchAll('SELECT * FROM user');
    }

    public function insert($name, $email, $password)
    {
        //hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Prepare parameters
        $parameters = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash
        ];
        $rows = $this->execute('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)', $parameters);

        return $rows == 1;
    }

    public function verify($email, $password)
    {
        //retrieve user
        $user = $this->getByEmail($email);
        $userHash = $user['password'];

        //verify user password
        $verify = password_verify($password, $userHash);

        return $verify;
    }

    public function generateToken($userId)
    {
        //Create Token Payload
        $payload = [
            'user_id' => $userId,
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getUserToken($userId)
    {
        $payload = [
            'user_id' => $userId,
        ];

        if (isset($userToken)) {
            $payload = $this->getTokenPayload($payload);
            $userId = $payload['user_id'];
        }
    }

    public function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];

        // Generate signature and verify
        return $this->generateToken($userId) == $token;
    }

    public static function getCurrentUserId()
    {
        return self::$currentUserId;
    }

    public static function setCurrentUserId($userId)
    {
        self::$currentUserId = $userId;
    }
}
