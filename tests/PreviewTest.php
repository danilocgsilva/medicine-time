<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests;

use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;
use Danilocgsilva\MedicineTime\Preview;

class PreviewTest extends TestCaseDB
{
    use StorageTrait, MedicineTrait;

    public function testRemainingInDays()
    {
        $medicine = $this->createMedicineInDatabase();
        $storage = $this->createStorageInDatabase();
        $preview = new Preview();

        $this->assertSame(0, 1);
    }

    public function testConsumingByPeriod()
    {
        $preview = new Preview();

        $preview->consumingByPeriod(DateTime::createFromFormat(""))
    }

    private function createMedicineInDatabase()
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $medicinesRepository = new MedicinesRepository($this->pdo);
        $medicinesRepository->save($medicine);
        return $medicinesRepository->list()[0];
    }

    private function createStorageInDatabase()
    {
        $this->renewByMigration(new M01StorageMigration());
        $storage = $this->createTestingStorage("default");
        $storageRepository = new StorageRepository($this->pdo);
        $storageRepository->save($storage);
        return $storageRepository->list()[0];
    }
}

