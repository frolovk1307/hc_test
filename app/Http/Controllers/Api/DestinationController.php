<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DestinationRequest;
use App\Services\DestinationSearch\DestinationData;
use App\Services\DestinationSearch\DestinationsRepository;
use App\Services\DestinationSearch\RangeFilter;

class DestinationController extends Controller
{
    public function index(DestinationRequest $request, DestinationsRepository $repository, RangeFilter $filter)
    {
        $searchParameters = $request->validated();
        $destinations = $filter
            ->setPlace($searchParameters['place'])
            ->setRadius($searchParameters['radius'])
            ->filter($repository->getAll());
        usort($destinations, function (DestinationData $first, DestinationData $second) {
            return $first->getRange() > $second->getRange();
        });

        $result = array_map(function (DestinationData $destinationData) {
            return [
                'name' => $destinationData->getName(),
                'range' => round($destinationData->getRange() / 1000, 2),
            ];
        }, $destinations);
        return response()->json([
            'data' => $result,
        ]);
    }
}
