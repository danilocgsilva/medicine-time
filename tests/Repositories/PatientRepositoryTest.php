<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Migrations\M02MedicinePatientMigration;

class PatientRepositoryTest extends TestCaseDB
{
    use PatientTrait, MedicineTrait;

    private PatientRepository $patientRepository;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->patientRepository = new PatientRepository($this->pdo);
    }
    
    public function testSaveAndRecover()
    {
        $this->renewByMigration(new M01PatientMigration());
        
        $patient = $this->createTestingPatient("John Doe");
        $this->patientRepository->save($patient);
        $listing = $this->patientRepository->list();

        $this->assertCount(1, $listing);
    }

    public function testRecoverWithMedicine()
    {
        $this->renewByMigration(new M01PatientMigration());
        $this->renewByMigration(new M01MedicinesMigration());

        $patient = $this->createTestingPatient("Evelyn Martins");
        $patient->setId(1);
        $medicine = $this->createTestingMedicine("Levotiroxina Sódica 50mcg");
        $medicine->setId(1);
        $patient->assignMedicine($medicine);

        $this->patientRepository->save($patient);

        $recoveredPatient = $this->patientRepository->list()[0];
        $recoveredMedicineRequired = $recoveredPatient->getMedicinesRequired()[0];

        $this->assertSame("Levotiroxina Sódica 50mcg", $recoveredMedicineRequired->getName());
    }

    public function testHasMedicineAssigmentFalse()
    {
        $this->renewByMigration(new M01PatientMigration());
        $this->renewByMigration(new M02MedicinePatientMigration());

        $patient = $this->createTestingPatient("Evelyn Martins");
        $this->patientRepository->save($patient);

        $recoveredPatient = $this->patientRepository->list()[0];

        $this->assertSame(false, $this->patientRepository->hasMedicineAssigment($recoveredPatient));
    }

    public function testHasMedicineAssigmentTrue()
    {
        $this->renewByMigration(new M01PatientMigration());
        $this->renewByMigration(new M02MedicinePatientMigration());

        $patient = $this->createTestingPatient("Evelyn Martins");
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $medicine->setId(1);
        $patient->assignMedicine($medicine);

        $this->patientRepository->save($patient);

        $recoveredPatient = $this->patientRepository->list()[0];

        $this->assertSame(true, $this->patientRepository->hasMedicineAssigment($recoveredPatient));
    }
}
