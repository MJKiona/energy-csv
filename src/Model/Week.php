<?php

declare(strict_types=1);

namespace Kiona\Model;

use Assert\Assertion;
use Kiona\Data\Formatter;

final class Week
{
    private string $year;
    private string $week;
    private string $yearWeek;
    private int $sum;
    private int $peakValue;
    private string $peakTime;

    private function __construct(string $year, string $week, int $sum, int $peakValue, string $peakTime)
    {
        $this->year = $year;
        $this->week = $week;
        $this->yearWeek = sprintf('%s-%s', $this->year, $this->week);
        $this->sum = $sum;
        $this->peakValue = $peakValue;
        $this->peakTime = $peakTime;
    }

    public function toArray(): array
    {
        return [
            $this->getYear(),
            $this->getWeek(),
            $this->getSumFormatted(),
            $this->getPeakValueFormatted(),
            $this->getPeakTime(),
        ];
    }
    public static function createFromData(Data $data): self
    {
        return new self(
            $data->getStartYear(),
            $data->getStartWeek(),
            $data->getEnergyConsumption(),
            $data->getEnergyConsumption(),
            $data->getEndTimeStamp()
        );
    }

    public function add(Data $data): self
    {
        Assertion::same($this->yearWeek, $data->getStartYearWeek());

        $this->sum += $data->getEnergyConsumption();

        if ($data->getEnergyConsumption() > $this->peakValue) {
            $this->peakValue = $data->getEnergyConsumption();
            $this->peakTime = $data->getEndTimeStamp();
        }

        return $this;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getWeek(): string
    {
        return $this->week;
    }

    public function getSumFormatted(): string
    {
        return Formatter::toDecimal($this->sum);
    }

    public function getPeakValueFormatted(): string
    {
        return Formatter::toDecimal($this->peakValue);
    }

    public function getPeakTime(): string
    {
        return $this->peakTime;
    }
}
