<?php


namespace App\Services\DestinationSearch;


class FileRepository implements DestinationsRepository
{
    /** @var string */
    private $filename;

    /** @var array */
    private $headerColumns;

    /** @var array */
    private $destinationsData;

    public function __construct(string $filename = null)
    {
        $this->filename = $filename ?? config('services.destination_search.file_name');
        if (!file_exists($this->filename)) {
            throw new \InvalidArgumentException("File doesn't exists: {$this->filename}");
        }
        $this->headerColumns = config('services.destination_search.header_columns');
    }

    public function setHeaderColumns(array $value): void
    {
        $this->headerColumns = $value;
    }

    /**
     * @return DestinationData[]|array
     */
    public function getAll(): array
    {
        if (!isset($this->destinationsData)) {
            $this->parseCsv();
        }

        return $this->destinationsData;
    }

    private function parseCsv(): void
    {
        $csvRows = $this->getCsvRows();

        if (isset($this->headerColumns)) {
            $headerColumns = array_shift($csvRows);
            if ($headerColumns !== $this->headerColumns) {
                throw new \LogicException('Invalid csv structure');
            }
        }

        $destinations = [];
        foreach ($csvRows as $row) {
            [$latitude, $longitude] = explode(',', $row[1]);
            $destinations[] = new DestinationData([
                'name' => $row[0],
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }

        $this->destinationsData = $destinations;
    }

    private function getCsvRows(): array
    {
        $rows = [];
        $fileResource = fopen($this->filename, 'r');
        while (!feof($fileResource)) {
            $row = fgetcsv($fileResource);
            if (is_array($row)) {
                $rows[] = $row;
            }
        }
        fclose($fileResource);
        return $rows;
    }
}
