<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;

class Authentication
{
    private $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate with the REST API.
     */
    public function login($username, $password)
    {
        $response = $this->request(
            'POST', 'login', [
            RequestOptions::JSON => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        return $response->data;
    }

    /**
     * Invalidate your REST API authentication token.
     */
    public function logout($authToken, $userId)
    {
        $response = $this->request(
            'GET', 'logout', [
            'headers' => [
                'X-Auth-Token' => $authToken,
                'X-User-Id' => $userId
            ]
        ]);

        return $response->data;
    }
}