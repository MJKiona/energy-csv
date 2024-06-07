<?php

declare(strict_types=1);

namespace Kiona\Model;

use Assert\Assertion;
use Kiona\Data\Formatter;

final class Day
{
    private string $date;
    private int $sum;
    private int $peakValue;
    private string $peakTime;

    private function __construct(string $date, int $sum, int $peakValue, string $peakTime)
    {
        $this->date = $date;
        $this->sum = $sum;
        $this->peakValue = $peakValue;
        $this->peakTime = $peakTime;
    }

    public function toArray(): array
    {
        return [
            $this->getDate(),
            $this->getSumFormatted(),
            $this->getPeakValueFormatted(),
            $this->getPeakTime(),
        ];
    }

    public static function createFromData(Data $data): self
    {
        return new self(
            $data->getStartDate(),
            $data->getEnergyConsumption(),
            $data->getEnergyConsumption(),
            $data->getEndTimeStamp()
        );
    }

    public function add(Data $data): self
    {
        Assertion::same($this->date, $data->getStartDate());

        $this->sum += $data->getEnergyConsumption();

        if ($data->getEnergyConsumption() > $this->peakValue) {
            $this->peakValue = $data->getEnergyConsumption();
            $this->peakTime = $data->getEndTimeStamp();
        }

        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
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
