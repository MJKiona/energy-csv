<?php

declare(strict_types=1);

namespace Kiona\Report;

use Kiona\Model\Data;
use Kiona\Model\Week;

final class Weekly
{
    /**
     * @var array<string, Week>
     */
    private array $collection = [];

    public static function create(): self
    {
        return new self();
    }

    public function add(Data $data): self
    {
        $yearWeek = $data->getStartYearWeek();

        if (array_key_exists($yearWeek, $this->collection)) {
            $this->collection[$yearWeek]->add($data);
        } else {
            $this->collection[$yearWeek] = Week::createFromData($data);
        }

        return $this;
    }

    /**
     * @return Week[]
     */
    public function getAll(): array
    {
        return $this->collection;
    }
}
