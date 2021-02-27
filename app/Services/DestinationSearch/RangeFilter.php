<?php


namespace App\Services\DestinationSearch;


class RangeFilter
{
    /** @var string */
    private $place;

    /** @var integer */
    private $radius;

    /**
     * @param string $place
     * @return RangeFilter
     */
    public function setPlace(string $place)
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @param int $radius
     * @return RangeFilter
     */
    public function setRadius(int $radius)
    {
        if ($radius < 0) {
            throw new \InvalidArgumentException('Radius must be mote than 0.');
        }
        $this->radius = $radius;
        return $this;
    }

    /**
     * @param DestinationData[]|array $destinations
     * @return DestinationData[]|array
     */
    public function filter(array $destinations): array
    {
        if (!isset($this->place, $this->radius)) {
            throw new \LogicException('Not enough conditions for filtration');
        }

        if ($this->radius === 0) {
            return [];
        }

        $initialPlace = null;
        /** @var DestinationData $destination */
        foreach ($destinations as $index => $destination) {
            if ($destination->getName() === $this->place) {
                $initialPlace = $destination;
                unset($destinations[$index]);
            }
        }
        if (!isset($initialPlace)) {
            throw new \LogicException('Undefined initial place');
        }
        foreach ($destinations as $index => $destination) {
            $destination->calculateRange($initialPlace);
            //todo fix adhoc km and m difference fix
            if ($destination->getRange() / 1000 > $this->radius) {
                unset($destinations[$index]);
            }
        }

        return array_values($destinations);
    }
}
