<?php namespace Yiin\RocketChat\API;

use Yiin\RocketChat\Client;
use GuzzleHttp\RequestOptions;

class Channels
{
    private $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Removes the channel from the user’s list of channels.
     */
    public function close($roomId)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'channels.close', [
            RequestOptions::JSON => [
                'roomId' => $roomId
            ]
        ]);

        return $response;
    }

    /**
     * Removes a user from the channel.
     */
    public function kick($roomId, $userId)
    {
        $response = $this->client->requestWithAuth(
            'POST', 'channels.kick', [
            RequestOptions::JSON => [
                'roomId' => $roomId,
                'userId' => $userId
            ]
        ]);

        return $response;
    }
}