<?php namespace Yiin\RocketChat;

use GuzzleHttp\Client as HttpClient;

/**
 *  Rocket.chat REST API Client
 */
class Client {
    /**
     * HTTP client that we use for communication with Rocket.chat REST API.
     * @var HttpClient
     */
    private $httpClient = null;

    /**
     * Currently authenticated user auth details.
     * @var array
     */
    private $auth = null;

    /**
     * @param string $apiURL URL of the API (e.g. 'http://localhost:3000/api/v1')
     */
    public function __construct(string $apiUrl)
    {
        $this->httpClient = new HttpClient([
            'base_uri' => trim($apiUrl, '/')
        ]);
    }

    /**
     * Login to API and authorize subsequent requests
     * as user we just logged in.
     */
    public function loginAs($username, $password)
    {
        $response = $this->request(
            'POST', '/login', [
            'body' => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        if (($response->status ?? 'error') === 'success' ) {
            $this->auth = [
                'auth_token' => $response->data->authToken,
                'user_id' => $response->data->userId
            ];
            return true;
        } else {
            throw $this->createExceptionFromResponse($response, 'loginAs');
        }
    }

    /**
     * Get auth details of users Rocket.chat account.
     */
    public function loginFor($username, $password)
    {
        $response = $this->request(
            'POST', '/login', [
            'body' => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        return [
            'auth_token' => $response->data->authToken,
            'user_id' => $response->data->userId
        ];
    }

    protected function request($type, $endpoint, $options = [])
    {
        $response = $this->httpClient->request(
            $type, $endpoint, $options
        );

        return json_decode((string) $response->getBody());
    }

    protected function createExceptionFromResponse($response, $prefix)
    {
        if (!empty($response->error)) {
            return new \Exception("$prefix: {$response->error}");
        } else if (!empty($response->message)) {
            return new \Exception("$prefix: {$response->message}");
        } else if (!empty($response) && is_string($response)) {
            return new \Exception("$prefix: {$response}");
        } else {
            return new \Exception("$prefix: unknown error.");
        }
    }
}