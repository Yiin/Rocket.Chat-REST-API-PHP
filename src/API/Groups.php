<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;
use GuzzleHttp\RequestOptions;

class Groups
{
    private $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Adds all of the users of the Rocket.Chat server to the group.
     * https://rocket.chat/docs/developer-guides/rest-api/groups/addall/
     */
    public function addAll($roomId, $activeUsersOnly = null)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'groups.addAll', [
            RequestOptions::JSON => array_filter([
                'roomId' => $roomId,
                'activeUsersOnly' => $activeUsersOnly
            ])
        ]);

        return $response;
    }

    /**
     * Creates a new private group, optionally including specified users.
     * The group creator is always included.
     * https://rocket.chat/docs/developer-guides/rest-api/groups/create/
     */
    public function create($name, $members = null, $readOnly = null)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'groups.addAll', [
            RequestOptions::JSON => array_filter([
                'name' => $name,
                'members' => $members,
                'readOnly' => $readOnly
            ])
        ]);

        return $response;
    }

    /**
     * Retrieves the information about the private group, only if you’re part of the group.
     * https://rocket.chat/docs/developer-guides/rest-api/groups/info/
     */
    public function info($key, $nameOrId)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'groups.info', [
            RequestOptions::JSON => [
                $key => $nameOrId
            ]
        ]);

        return $response;
    }
}