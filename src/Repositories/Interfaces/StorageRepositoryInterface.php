<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Storage;

interface StorageRepositoryInterface
{
    /**
     * List all storages from system
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\Storage[]
     */
    public function list(): array;

    /**
     * Registers a storage.
     *
     * @param Storage $storage
     * @return void
     */
    public function save(Storage $storage): void;
}
