<?php

declare(strict_types=1);

namespace Kiona\Model;

use Assert\Assertion;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeZone;

final class Data
{
    private DatePeriod $datePeriod;
    private int $energyConsumption;

    private function __construct(array $row)
    {
        Assertion::keyExists($row, 0);
        Assertion::keyExists($row, 1);
        Assertion::keyExists($row, 2);

        $timezone = new DateTimeZone('UTC');
        $periodEnd = new DateTimeImmutable('@' . $row[0], $timezone);
        $periodStart = $periodEnd->modify('-1 hour');
        $interval = DateInterval::createFromDateString('1 hour');
        $this->datePeriod = new DatePeriod($periodStart, $interval, $periodEnd);

        $this->energyConsumption = (int) (floatval($row[2]) * 100);
    }

    public static function createFromCsvRow(array $row): self
    {
        return new self($row);
    }

    public function getDatePeriod(): DatePeriod
    {
        return $this->datePeriod;
    }

    public function getStartDate(): string
    {
        return $this->datePeriod->getStartDate()->format('Y-m-d');
    }

    public function getEndTimeStamp(): string
    {
        return $this->datePeriod->getEndDate()->format('Y-m-d H:i:s');
    }

    public function getStartYear(): string
    {
        return $this->datePeriod->getStartDate()->format('Y');
    }

    public function getStartYearWeek(): string
    {
        return $this->datePeriod->getStartDate()->format('Y-W');
    }

    public function getStartYearMonth(): string
    {
        return $this->datePeriod->getStartDate()->format('Y-m');
    }

    public function getStartMonth(): string
    {
        return $this->datePeriod->getStartDate()->format('m');
    }

    public function getStartWeek(): string
    {
        return $this->datePeriod->getStartDate()->format('W');
    }

    public function getEnergyConsumption(): int
    {
        return $this->energyConsumption;
    }
}
