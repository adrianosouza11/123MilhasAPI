<?php


namespace App\Http\Controllers;

use Components\FlightAPI\FlightAPIService;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class FlightController extends Controller
{
    public function findAllFlights(): JsonResponse
    {
        $flightAPI = new FlightAPIService(env('API_123MILHAS_URL'));

        $getFlightsGroup = $flightAPI->findAllGrouped();

        if (!empty($getFlightsGroup))
            $getFlightsGroup = $this->formatGroupToResult($getFlightsGroup);

        return Response()->json($getFlightsGroup);
    }

    private function formatGroupToResult(array $flightsGroup) : array
    {
        ksort($flightsGroup);

        $result = array();

        $numberGroups = 1;
        $totalFlights = 0;
        foreach ($flightsGroup as $priceGroup => $inOutboundGroup) {

            $result['flights']['groups'][] = array_merge(['uniqueId' => $numberGroups, 'totalPrice' => $priceGroup], $inOutboundGroup);

            $totalFlights += isset($inOutboundGroup['inbound']) ? count($inOutboundGroup['inbound']) : 0;
            $totalFlights += isset($inOutboundGroup['outbound']) ? count($inOutboundGroup['outbound']) : 0;

            $numberGroups++;
        }

        $result = array_merge($result, [
            'totalGroups' => $numberGroups,
            'totalFlights' => $totalFlights,
            'cheapestPrice' => key($flightsGroup),
            'cheapestGroup' => $numberGroups
        ]);

        return $result;
    }
}