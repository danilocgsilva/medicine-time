<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M02MedicineStorageMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicineHourMigration;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Repositories\MedicineStorageRepository;

class MedicineStorageRepositoryTest extends TestCaseDB
{
    use PatientTrait;
    use MedicineTrait;
    use StorageTrait;

    private PatientRepository $patientRepository;

    private MedicinesRepository $medicinesRepository;

    private StorageRepository $storageRepository;

    private MedicineStorageRepository $medicineStorageRepository;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->patientRepository = new PatientRepository($this->pdo);
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
        $this->storageRepository = new StorageRepository($this->pdo);
        $this->medicineStorageRepository = new MedicineStorageRepository($this->pdo);
    }

    public function testSetAndGetRemainingPills()
    {
        $this->renewByMigration(new M02MedicineStorageMigration());
        $this->renewByMigration(new M01MedicineHourMigration());
        $this->renewByMigration(new M01StorageMigration());
        $this->renewByMigration(new M01PatientMigration());

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 12);

        $this->assertSame(12, $this->medicineStorageRepository->getRemainingPills($defaultStorage, $medicine));
    }
}
