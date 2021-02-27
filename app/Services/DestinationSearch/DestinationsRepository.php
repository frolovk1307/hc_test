<?php


namespace App\Services\DestinationSearch;


interface DestinationsRepository
{
    /**
     * @return DestinationData[]|array
     */
    public function getAll(): array;
}
