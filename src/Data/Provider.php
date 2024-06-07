<?php

declare(strict_types=1);

namespace Kiona\Data;

use Assert\Assertion;
use Generator;
use Kiona\File\Csv\Reader;
use Kiona\Model\Data;

final class Provider
{
    private Reader $csvFileReader;

    public function __construct()
    {
        $this->csvFileReader = new Reader();
    }

    private function assertColumn(array $row, int $columnIndex, int $rowNumber): void
    {
        Assertion::keyExists(
            $row,
            $columnIndex,
            sprintf('Missing value for column %d on line %d', $columnIndex, $rowNumber)
        );
    }

    public function provide(string $fileName): Generator
    {
        foreach ($this->csvFileReader->getRows($fileName) as $rowNumber => $row) {
            $rowNumber++;

            $this->assertColumn($row[$rowNumber], 0, $rowNumber);
            $this->assertColumn($row[$rowNumber], 1, $rowNumber);
            $this->assertColumn($row[$rowNumber], 2, $rowNumber);

            yield Data::createFromCsvRow($row[$rowNumber]);
        }
    }
}
