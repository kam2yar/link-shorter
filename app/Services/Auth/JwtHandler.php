<?php

namespace App\Services\Auth;

use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JwtHandler
{
    function encodeToken($data): string
    {
        $token = array(
            'iss' => url(),
            'iat' => time(),
            'exp' => time() + $_ENV['JWT_LIFE'],
            'data' => $data
        );

        return JWT::encode($token, $_ENV['JWT_SECRET'], 'HS256');
    }

    function decodeToken($token)
    {
        try {
            $decode = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            return $decode->data;
        } catch (ExpiredException|SignatureInvalidException $e) {
            response()->httpCode(401)->json([
                'message' => $e->getMessage()
            ]);
        } catch (UnexpectedValueException|Exception $e) {
            response()->httpCode(400)->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
