<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;
use GuzzleHttp\RequestOptions;

class Settings
{
    private $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all private settings.
     * https://rocket.chat/docs/developer-guides/rest-api/settings/get/
     */
    public function get()
    {
        $response = $this->client->requestWithAuth(
            'GET', 'settings'
        );

        return $response;
    }

    /**
     * Gets the setting for the provided _id.
     * https://rocket.chat/docs/developer-guides/rest-api/settings/get-by-id/
     */
    public function getById($_id)
    {
        $reponse = $this->client->requestWithAuth(
            'GET', "settings/$_id"
        );

        return $response;
    }

    /**
     * Updates the setting for the provided _id.
     * https://rocket.chat/docs/developer-guides/rest-api/settings/update/
     */
    public function update($_id, $value)
    {
        $response = $this->client->requestWithAuth(
            'POST', "settings/$_id", [
            RequestOptions::JSON => [
                'value' => $value
            ]
        ]);

        return $response;
    }
}