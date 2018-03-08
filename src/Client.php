<?php namespace Yiin\RocketChat;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

/**
 * Rocket.chat REST API Client
 */
class Client
{
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
            'base_uri' => trim($apiUrl, '/') . '/'
        ]);
    }

    /**
     * Login to API and authorize subsequent requests
     * as user we just logged in.
     */
    public function loginAs($username, $password)
    {
        $response = $this->request(
            'POST', 'login', [
            RequestOptions::JSON => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        if (($response->status ?? 'error') === 'success' ) {
            $this->auth = $response->data;
            return true;
        } else {
            $this->auth = null;
            throw $this->createExceptionFromResponse($response, 'loginAs');
        }
    }

    public function authenticateWith($authKey, $userId, Callable $callback)
    {
        $auth = $this->auth;

        $this->auth = [
            'authKey' => $authKey,
            'userId' => $userId
        ];

        $callback();

        $this->auth = $auth;
    }

    /**
     * REST API Authentication
     * https://rocket.chat/docs/developer-guides/rest-api/authentication/
     */
    public function authenticationAPI()
    {
        return new API\Authentication($this);
    }

    /**
     * REST API Users
     * https://rocket.chat/docs/developer-guides/rest-api/users/
     */
    public function usersAPI()
    {
        return new API\Users($this);
    }

    /**
     * Helper methods
     */
    public function request($type, $endpoint, $options = [])
    {
        $response = $this->httpClient->request(
            $type, $endpoint, $options
        );

        $responseBody = (string) $response->getBody();
        $data = json_decode($responseBody);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
        return $responseBody;
    }

    public function requestWithAuth($type, $endpoint, $options = [])
    {
        if (!$this->auth) {
            return $this->request($type, $endpoint, $options);
        }

        return $this->request($type, $endpoint, array_merge($options, [
            'headers' => [
                'X-Auth-Token' => $this->auth->authToken,
                'X-User-Id' => $this->auth->userId
            ]
        ]));
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