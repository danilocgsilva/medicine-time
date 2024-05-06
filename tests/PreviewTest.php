<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests;

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

class PreviewTest extends TestCaseDB
{
    use StorageTrait, MedicineTrait, PatientTrait;

    public function testRemainingInDays()
    {
        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $storage = $this->createStorageInDatabase();
        $preview = new Preview();

        $this->assertSame(0, 1);
    }

    public function testConsumingByPeriod(): void
    {
        $this->renewMigrations();
        
        $preview = new Preview();
        $medicineHourRepository = new MedicineHourRepository($this->pdo);

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $patient = $this->createPatientInDatabase();

        $medicineHourRepository->addManagementHour(9, $medicine, $patient);

        $consumed = $preview->consumingByPeriod(
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 00:00:00"),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 12:00:00"),
            $medicine,
            new MedicineHourRepository($this->pdo)
        );

        $this->assertSame(1, $consumed);
    }

    public function testConsumingByPeriodTiny()
    {
        $this->renewMigrations();
        
        $preview = new Preview();
        $medicineHourRepository = new MedicineHourRepository($this->pdo);

        $medicine = $this->createMedicineInDatabase("Cilostazol 100mg");
        $patient = $this->createPatientInDatabase();

        $medicineHourRepository->addManagementHour(9, $medicine, $patient);

        $consumed = $preview->consumingByPeriod(
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 00:00:00"),
            DateTime::createFromFormat("Y-m-d H:i:s", "2024-04-01 7:00:00"),
            $medicine,
            new MedicineHourRepository($this->pdo)
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

    private function createPatientInDatabase(): Patient
    {
        $patient = $this->createTestingPatient("Helena Dias");
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

