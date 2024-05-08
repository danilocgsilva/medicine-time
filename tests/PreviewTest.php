<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests;

use Danilocgsilva\MedicineTime\Migrations\M02MedicineStorageMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicineHourMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;
use Danilocgsilva\MedicineTime\Preview;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use DateTime;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Entities\Patient;
use Danilocgsilva\MedicineTime\Repositories\MedicineStorageRepository;

class PreviewTest extends TestCaseDB
{
    use StorageTrait, MedicineTrait, PatientTrait;

    public function testRemainingInDays()
    {
        $this->renewMigrations();
        $this->renewByMigration(new M02MedicineStorageMigration());

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $storage = $this->createStorageInDatabase();
        $medicineStorageRepository = new MedicineStorageRepository($this->pdo);
        $medicineStorageRepository->setRemainingPills($storage, $medicine, 12, "2024-03-12 00:00:00");

        $preview = new Preview(new MedicineHourRepository($this->pdo));
        $remainingInDays = $preview->remainingInDays(
            [$storage], 
            $medicine, 
            [], 
            new MedicineStorageRepository($this->pdo),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-03-15 00:00:00")
        );

        $this->assertSame(12, $remainingInDays);
    }

    public function testRemainingInDaysWithPatientConsuming()
    {
        $this->renewMigrations();
        $this->renewByMigration(new M02MedicineStorageMigration());

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $storage = $this->createStorageInDatabase();
        $patient = $this->createPatientInDatabase("Helena Diaz");

        $medicineStorageRepository = new MedicineStorageRepository($this->pdo);
        $medicineStorageRepository->setRemainingPills($storage, $medicine, 12, "2024-03-12 00:00:00");

        $medicineHourRepository = new MedicineHourRepository($this->pdo);
        $medicineHourRepository->addManagementHour(9, $medicine, $patient);

        $preview = new Preview(new MedicineHourRepository($this->pdo));
        $remainingInDays = $preview->remainingInDays(
            [$storage], 
            $medicine, 
            [], 
            new MedicineStorageRepository($this->pdo),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-03-15 00:00:00")
        );

        $this->assertSame(9, $remainingInDays);
    }

    public function testConsumingByPeriod(): void
    {
        $this->renewMigrations();
        
        $preview = new Preview(new MedicineHourRepository($this->pdo));
        $medicineHourRepository = new MedicineHourRepository($this->pdo);

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $patient = $this->createPatientInDatabase("Emerson Leão");

        $medicineHourRepository->addManagementHour(9, $medicine, $patient);

        $consumed = $preview->consumingByPeriod(
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 00:00:00"),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 12:00:00"),
            $medicine
        );

        $this->assertSame(1, $consumed);
    }

    public function testConsumingByPeriodTiny()
    {
        $this->renewMigrations();
        
        $preview = new Preview(new MedicineHourRepository($this->pdo));
        $medicineHourRepository = new MedicineHourRepository($this->pdo);

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $patient = $this->createPatientInDatabase("Thiago Martins");

        $medicineHourRepository->addManagementHour(9, $medicine, $patient);

        $consumed = $preview->consumingByPeriod(
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 00:00:00"),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 7:00:00"),
            $medicine
        );

        $this->assertSame(0, $consumed);
    }

    /**
     * Stores a medicine in database.
     *
     * @param string $name
     * @return Medicine
     */
    private function createMedicineInDatabase(string $name): Medicine
    {
        $medicine = $this->createTestingMedicine($name);
        $medicinesRepository = new MedicinesRepository($this->pdo);
        $medicinesRepository->save($medicine);
        return $medicinesRepository->list()[0];
    }

    private function createStorageInDatabase()
    {
        $storage = $this->createTestingStorage("default");
        $storageRepository = new StorageRepository($this->pdo);
        $storageRepository->save($storage);
        return $storageRepository->list()[0];
    }

    private function createPatientInDatabase(string $patientName): Patient
    {
        $patient = $this->createTestingPatient($patientName);
        $patientRepository = new PatientRepository($this->pdo);
        $patientRepository->save($patient);
        return $patientRepository->list()[0];
    }

    private function renewMigrations()
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $this->renewByMigration(new M01StorageMigration());
        $this->renewByMigration(new M01PatientMigration());
        $this->renewByMigration(new M01MedicineHourMigration());
    }
}

