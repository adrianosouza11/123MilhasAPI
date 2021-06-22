<?php

namespace Components\FlightAPI\Entities;

class FlightGroupsEntity
{
    private $flights;

    private $groupByFareValueInOutbound;

    private $groupBestFlights;

    public function __construct(array $flightSet)
    {
        $this->flights = $flightSet;

        $this->getGroupBestFlights();
    }

    public function getGroupBestFlights() : array
    {
        $groupBestFlights = [];

        $this->processByFareValueInOutbound();

        foreach ($this->groupByFareValueInOutbound as $fareGroup => $priceGroup){
            foreach ($priceGroup as $idxPriceGroup => $inOutboundGroup){

                ksort($priceGroup, SORT_NUMERIC);

                $findIdx = key($inOutboundGroup) == 'inbound' ? 'outbound' : 'inbound';

                array_filter($priceGroup, function($eachCallback) use ($groupBestFlights, $findIdx, $idxPriceGroup,$inOutboundGroup){
                    $getInOutBound = in_array($findIdx,array_keys($eachCallback)) ? $eachCallback : null;


                    if ($getInOutBound != null && !isset($getInOutBound['inbound'], $getInOutBound['outbound'])){
                        $price = $getInOutBound[$findIdx][0]['price'];
                        $amount = $idxPriceGroup + $price;
                        $this->groupBestFlights[$amount] = array_merge($inOutboundGroup, $getInOutBound);
                    }
                });
            }
        }

        return $this->groupBestFlights;
    }

    private function processByFareValueInOutbound() : void
    {
        $flightGroups = [];

        foreach ($this->flights as $eachFlight){
            if ($eachFlight['outbound'] != 0) {
                $flightGroups[$eachFlight['fare']][$eachFlight['price']]['outbound'][] = $eachFlight;
            }

            if ($eachFlight['inbound'] != 0) {
                $flightGroups[$eachFlight['fare']][$eachFlight['price']]['inbound'][] = $eachFlight;
            }
        }

        $this->groupByFareValueInOutbound = $flightGroups;
    }
}