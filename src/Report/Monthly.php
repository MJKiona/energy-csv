<?php

declare(strict_types=1);

namespace Kiona\Report;

use Kiona\Model\Data;
use Kiona\Model\Month;

final class Monthly
{
    /**
     * @var array<string, Month>
     */
    private array $collection = [];

    public static function create(): self
    {
        return new self();
    }

    public function add(Data $data): self
    {
        $yearMonth = $data->getStartYearMonth();

        if (array_key_exists($yearMonth, $this->collection)) {
            $this->collection[$yearMonth]->add($data);
        } else {
            $this->collection[$yearMonth] = Month::createFromData($data);
        }

        return $this;
    }

    /**
     * @return Month[]
     */
    public function getAll(): array
    {
        return $this->collection;
    }
}
