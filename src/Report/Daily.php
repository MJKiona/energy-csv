<?php

declare(strict_types=1);

namespace Kiona\Report;

use Kiona\Model\Data;
use Kiona\Model\Day;

final class Daily
{
    /**
     * @var array<string, Day>
     */
    private array $collection = [];

    public static function create(): self
    {
        return new self();
    }

    public function add(Data $data): self
    {
        $date = $data->getStartDate();

        if (array_key_exists($date, $this->collection)) {
            $this->collection[$date]->add($data);
        } else {
            $this->collection[$date] = Day::createFromData($data);
        }

        return $this;
    }

    /**
     * @return Day[]
     */
    public function getAll(): array
    {
        return $this->collection;
    }
}
