<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Commons;

use Danilocgsilva\MedicineTime\Entities\Storage;

trait StorageTrait
{
    protected function createTestingStorage(string $storageName): Storage
    {
        $storage = new Storage();
        $storage->setName($storageName);
        return $storage;
    }
}
