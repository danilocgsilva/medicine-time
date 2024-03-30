<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

interface MedicineRepositoryInterface
{
    /**
     * List of medicines
     *
     * @return \Danilocgsilva\MedicineTime\Entities\Medicine[]
     */
    public function list(): array;
}
