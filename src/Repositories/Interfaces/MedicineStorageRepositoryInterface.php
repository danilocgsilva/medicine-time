<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Storage;

interface MedicineStorageRepositoryInterface
{
    /**
     * Return occurrences of medicines in a storage.
     *
     * @param Medicine $medicine
     * @param Storage $storage
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\MedicineStorage[]
     */
    public function findOccurrences(Medicine $medicine, Storage $storage): array;
}