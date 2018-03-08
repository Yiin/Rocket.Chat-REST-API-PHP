<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;
use GuzzleHttp\RequestOptions;

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
        $response = $this->client->request(
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
        $response = $this->client->request(
            'GET', 'logout', [
            'headers' => [
                'X-Auth-Token' => $authToken,
                'X-User-Id' => $userId
            ]
        ]);

        return $response->data;
    }

    public function me()
    {
        $response = $this->client->requestWithAuth(
            'GET', 'me'
        );

        return $response;
    }
}