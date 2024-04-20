<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

interface StorageRepositoryInterface
{
    /**
     * List all storages from system
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\Storage[]
     */
    public function list(): array;
}
