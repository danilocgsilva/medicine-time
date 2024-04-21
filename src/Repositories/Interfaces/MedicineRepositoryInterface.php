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

    /**
     * Register a medicine in the database
     *
     * @param Medicine $medicine
     * @return void
     */
    public function save(Medicine $medicine): void;
}
