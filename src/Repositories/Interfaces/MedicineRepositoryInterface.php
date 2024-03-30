<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;

interface MedicineRepositoryInterface
{
    /**
     * List of medicines
     *
     * @return \Danilocgsilva\MedicineTime\Entities\Medicine[]
     */
    public function list(): array;

    public function save(Medicine $medicine): self;
}
