<?php

declare(strict_types=1);

namespace Kiona\Model;

use Assert\Assertion;
use Kiona\Data\Formatter;

final class Month
{
    private string $year;
    private string $month;
    private string $yearMonth;
    private int $sum;
    private int $peakValue;
    private string $peakTime;

    private function __construct(string $year, string $month, int $sum, int $peakValue, string $peakTime)
    {
        $this->year = $year;
        $this->month = $month;
        $this->yearMonth = sprintf('%s-%s', $year, $month);
        $this->sum = $sum;
        $this->peakValue = $peakValue;
        $this->peakTime = $peakTime;
    }

    public function toArray(): array
    {
        return [
            $this->getYear(),
            $this->getMonth(),
            $this->getSumFormatted(),
            $this->getPeakValueFormatted(),
            $this->getPeakTime(),
        ];
    }

    public static function createFromData(Data $data): self
    {
        return new self(
            $data->getStartYear(),
            $data->getStartMonth(),
            $data->getEnergyConsumption(),
            $data->getEnergyConsumption(),
            $data->getEndTimeStamp()
        );
    }

    public function add(Data $data): self
    {
        Assertion::same($this->yearMonth, $data->getStartYearMonth());

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

    public function getMonth(): string
    {
        return $this->month;
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
