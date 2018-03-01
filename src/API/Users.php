<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;
use GuzzleHttp\RequestOptions;

class Users
{
    private $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates new Rocket.Chat user
     * https://rocket.chat/docs/developer-guides/rest-api/users/create/
     */
    public function create($username, $password, $name, $email, $optionalArguments = [])
    {
        $response = $this->client->requestWithAuth(
            'POST', 'users.create', [
            RequestOptions::JSON => array_merge([
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password
            ], $optionalArguments)
        ]);

        return $response;
    }

    /**
     * Create a user authentication token.
     * https://rocket.chat/docs/developer-guides/rest-api/users/createtoken/
     * 
     * @param $identifier string 'userId' or 'username'.
     * @param $value string id or username of the user.
     */
    public function createToken($identifier, $value)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'users.createToken', [
            RequestOptions::JSON => [
                $identifier => $value
            ]
        ]);

        return $response;
    }

    /**
     * Deletes an existing user.
     * https://rocket.chat/docs/developer-guides/rest-api/users/delete/
     */
    public function delete($id)
    {
        $this->client->requestWithAuth(
            'POST', 'users.delete', [
            RequestOptions::JSON => [
                'userId' => $id
            ]
        ]);

        return true;
    }

    /**
     * Gets the URL for a user’s avatar.
     * https://rocket.chat/docs/developer-guides/rest-api/users/getavatar/
     * 
     * @param $identifier string 'userId' or 'username'.
     * @param $value string id or username of the user.
     */
    public function getAvatar($identifier, $value)
    {
        $response = $this->client->request(
            'GET', 'users.getAvatar', [
            'query' => [
                $identifier => $value
            ]
        ]);

        return $response;
    }

    /**
     * Gets the online presence of the a user.
     * https://rocket.chat/docs/developer-guides/rest-api/users/getpresence/
     * 
     * @param $optionalIdentifier string 'userId' or 'username'.
     * @param $optionalValue string id or username of the user.
     */
    public function getPresence($optionalIdentifier = null, $optionalValue = null)
    {
        $response = $this->client->requestWithAuth(
            'GET', 'users.getPresence', [
            'query' => $optionalIdentifier && $optionalValue ? [
                $optionalIdentifier => $optionalValue
            ] : []
        ]);

        return $response;
    }

    /**
     * Gets the online presence of the a user.
     * https://rocket.chat/docs/developer-guides/rest-api/users/get-preferences/
     */
    public function getPreferences()
    {
        $response = $this->client->requestWithAuth(
            'GET', 'users.getPreferences'
        );

        return $response;
    }

    /**
     * Gets a user’s information, limited to the caller’s permissions.
     * https://rocket.chat/docs/developer-guides/rest-api/users/info/
     */
    public function info($userIdOrUsername)
    {
        $response = $this->client->requestWithAuth(
            'GET', 'users.getPreferences', [
            'query' => [
                'userId' => $userIdOrUsername
            ]
        ]);

        return $response;
    }

    /**
     * All of the users and their information, limited to permissions.
     * https://rocket.chat/docs/developer-guides/rest-api/users/list/
     */
    public function list($optionalFields = null, $optionalQuery = null)
    {
        $response = $this->client->requestWithAuth(
            'GET', 'users.getPreferences', [
            'query' => array_filter([
                'fields' => $optionalFields,
                'query' => $optionalQuery
            ])
        ]);

        return $response;
    }

    /**
     * All of the users and their information, limited to permissions.
     * https://rocket.chat/docs/developer-guides/rest-api/users/list/
     */
    public function register($username, $password, $name, $email, $optionalSecretURL = null)
    {
        $response = $this->client->request(
            'POST', 'users.register', [
            RequestOptions::JSON => array_filter([
                'username' => $username,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'secretURL' => $optionalSecretURL
            ])
        ]);

        return $response;
    }

    /**
     * All of the users and their information, limited to permissions.
     * https://rocket.chat/docs/developer-guides/rest-api/users/resetavatar/
     */
    public function resetAvatar($type, $value)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'users.resetAvatar', [
            RequestOptions::JSON => [
                $type => $value
            ]
        ]);

        return $response;
    }
}