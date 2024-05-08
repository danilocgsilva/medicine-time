<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Entities;

use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicineHourMigration;

class PatientTest extends TestCaseDB
{
    use PatientTrait;
    use MedicineTrait;

    private PatientRepository $patientRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->patientRepository = new PatientRepository($this->pdo);
    }

    public function testAssertId1()
    {
        $this->renewByMigration(new M01PatientMigration(), $this->dbEngine);
        $this->renewByMigration(new M01MedicineHourMigration(), $this->dbEngine);

        $patient = $this->storeTestingPatient("John Mike");

        $lastInserId = (int) $this->pdo->lastInsertId();
        $recoveredPatient = $this->patientRepository->list()[0];
        $this->assertSame($lastInserId, $recoveredPatient->getId());
    }

    public function testAssignMedicine()
    {
        $this->renewByMigration(new M01PatientMigration(), $this->dbEngine);
        
        $patient = $this->createTestingPatient("John Mike");

        $this->renewByMigration(new M01MedicinesMigration(), $this->dbEngine);
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");

        $patient->assignMedicine($medicine);

        $medicineRequired = $patient->getMedicinesRequired()[0];

        $this->assertSame("Cilostazol 100mg", $medicineRequired->getName());
    }
}
