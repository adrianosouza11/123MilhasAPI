<?php


namespace Components\FlightAPI;

use Components\FlightAPI\Entities\FlightGroupsEntity;
use GuzzleHttp\Client as ClientGuzzle;

class FlightAPIService
{
    private $loadGuzzleClient;

    public function __construct(string $baseUri)
    {
        $this->loadGuzzleClient = new ClientGuzzle([
            'base_uri' => $baseUri,
        ]);
    }

    public function findAll() : array
    {
        return $this->jsonToArray($this->loadGuzzleClient
            ->get('flights')
            ->getBody()
            ->getContents()
        );
    }

    public function findAllGrouped() : array
    {
         return (new FlightGroupsEntity($this->findAll()))->getGroupBestFlights();
    }

    private function jsonToArray($anywhere) : array
    {
        return json_decode($anywhere, true);
    }
}