<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M02MedicineStorageMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicineHourMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Repositories\MedicineStorageRepository;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use DateTime;
use Danilocgsilva\MedicineTime\Preview;

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
        $this->renewCommonTables();

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 12);
        $preview = new Preview();

        $this->assertSame(
            12, 
            $preview->getRemainingPills(
                $defaultStorage,
                $medicine,
                $this->medicineStorageRepository
            )
        );
    }

    public function testSetAndGetRemainingPillsWithDate()
    {
        $this->renewCommonTables();

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");
        $dateTime = "2024-04-15 00:00:00";

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 12, $dateTime);

        $preview = new Preview();

        $this->assertSame(
            12,
            $preview->getRemainingPills(
                $defaultStorage,
                $medicine,
                $this->medicineStorageRepository
            )
        );
    }

    public function testSetAndGetRemainingPillsWithDateAndConsumingPatient()
    {
        $this->renewCommonTables();
        $this->renewByMigration(new M01PatientMigration());

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");
        $dateTime = "2024-04-15 00:00:00";
        $consumingPatient = $this->storeTestingPatient("Renan Dias");

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 7, $dateTime);

        $medicineHourRepository = new MedicineHourRepository($this->pdo);

        $medicineHourRepository->addManagementHour(9, $medicine, $consumingPatient);

        $preview = new Preview();

        $this->assertSame(
            7,
            $preview->getRemainingPills(
                $defaultStorage,
                $medicine,
                $this->medicineStorageRepository,
                DateTime::createFromFormat('Y-m-d H:i:s', $dateTime)
            )
        );
    }

    public function testSetAndGetRemainingPillsWithDateAndConsumingPatientWithDifferenteDate()
    {
        $this->renewCommonTables();
        $this->renewByMigration(new M01PatientMigration());

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");
        $dateTime = "2024-04-15 00:00:00";
        $consumingPatient = $this->storeTestingPatient("Renan Dias");

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 7, $dateTime);

        (new MedicineHourRepository($this->pdo))
            ->addManagementHour(9, $medicine, $consumingPatient);

        $preview = new Preview();

        $this->assertSame(
            5,
            $preview->getRemainingPills(
                $defaultStorage,
                $medicine,
                $this->medicineStorageRepository,
                DateTime::createFromFormat('Y-m-d H:i:s', "2024-04-17 00:00:00")
            )
        );
    }

    public function testSetAndGetRemainingPillsWithDateAnndConsumingPatientWithDifferenteDate2()
    {
        $this->renewCommonTables();
        $this->renewByMigration(new M01PatientMigration());

        $medicine = $this->storeTestingMedicine("Atovarstatina Cálcica 80mg");
        $defaultStorage = $this->storeTestingStorage("Default");
        $dateTime = "2024-04-14 00:00:00";
        $consumingPatient = $this->storeTestingPatient("Renan Dias");

        $this->medicineStorageRepository->setRemainingPills($defaultStorage, $medicine, 9, $dateTime);

        $medicineHourRepository = new MedicineHourRepository($this->pdo);
        $medicineHourRepository->addManagementHour(9, $medicine, $consumingPatient);

        $dateTimeForCompare = DateTime::createFromFormat('Y-m-d H:i:s', "2024-04-17 00:00:00");

        $this->assertSame(
            6, 
            $this->medicineStorageRepository->getRemainingPills(
                $defaultStorage, 
                $medicine
            )
        );
    }

    private function renewCommonTables()
    {
        $this->renewByMigration(new M02MedicineStorageMigration());
        $this->renewByMigration(new M01MedicinesMigration());
        $this->renewByMigration(new M01StorageMigration());
        $this->renewByMigration(new M01MedicineHourMigration());
    }
}
