<?php


namespace App\Services\DestinationSearch;


use App\Helpers\HaversineGreatCircleDistanceCalculator;

class DestinationData
{
    /** @var string */
    private $name;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var float */
    private $range;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->latitude = (float)$data['latitude'];
        $this->longitude = (float)$data['longitude'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getRange(): float
    {
        return $this->range;
    }

    /**
     * @param DestinationData $otherPlace
     */
    public function calculateRange(DestinationData $otherPlace): void
    {
        $this->range = HaversineGreatCircleDistanceCalculator::calculate(
            $otherPlace->latitude,
            $otherPlace->longitude,
            $this->latitude,
            $this->longitude,
        );
    }
}
