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
     * https://rocket.chat/docs/developer-guides/rest-api/authentication/login/
     */
    public function login($user, $password)
    {
        $response = $this->client->request(
            'POST', 'login', [
            RequestOptions::JSON => [
                'user' => $user,
                'password' => $password
            ]
        ]);

        return $response->data;
    }

    /**
     * Invalidate your REST API authentication token.
     * https://rocket.chat/docs/developer-guides/rest-api/authentication/logout/
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

    /**
     * Quick information about the authenticated user.
     * https://rocket.chat/docs/developer-guides/rest-api/authentication/me/
     */
    public function me()
    {
        $response = $this->client->requestWithAuth(
            'GET', 'me'
        );

        return $response;
    }
}