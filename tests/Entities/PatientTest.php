<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Entities;

use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Migrations\M02MedicinePatientMigration;

class PatientTest extends TestCaseDB
{
    use PatientTrait;
    use MedicineTrait;

    public function testAssertId1()
    {
        $this->renewByMigration(new M01PatientMigration());
        $patient = $this->createTestingPatient("John Mike");
        $patientRepository = new PatientRepository($this->pdo);
        $patientRepository->save($patient);
        $lastInserId = (int) $this->pdo->lastInsertId();
        $recoveredPatient = $patientRepository->list()[0];
        $this->assertSame($lastInserId, $recoveredPatient->getId());
    }

    public function testAssignMedicine()
    {
        $this->renewByMigration(new M01PatientMigration());
        $this->renewByMigration(new M02MedicinePatientMigration());
        
        $patient = $this->createTestingPatient("John Mike");

        $this->renewByMigration(new M01MedicinesMigration());
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");

        $patient->assignMedicine($medicine);

        $medicineRequired = $patient->getMedicinesRequired()[0];

        $this->assertSame("Cilostazol 100mg", $medicineRequired->getName());
    }
}
