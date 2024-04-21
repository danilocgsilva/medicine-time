<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Storage;
use Danilocgsilva\MedicineTime\Entities\Medicine;

interface MedicineStorageRepositoryInterface
{
    public function getRemainingPills(Storage $storage, Medicine $medicine): int;
}