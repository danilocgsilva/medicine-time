<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineRepositoryInterface;

class MedicineTimeRepository implements MedicineRepositoryInterface
{
    /** @inheritdoc */
    public function list(): array
    {
        return [];
    }
}
