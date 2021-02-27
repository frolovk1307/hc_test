<?php

namespace App\Http\Controllers;

use App\Services\DestinationSearch\DestinationData;
use App\Services\DestinationSearch\DestinationsRepository;

class DestinationController extends Controller
{
    const MAX_RADIUS_VALUE = 1000;

    public function index(DestinationsRepository $repository)
    {
        $destinationNames = array_map(function (DestinationData $destinationData) {
            return $destinationData->getName();
        }, $repository->getAll());
        sort($destinationNames);

        return view('destination.index', [
            'destinationNames' => $destinationNames,
            'maxRadiusValue' => static::MAX_RADIUS_VALUE,
        ]);
    }
}
