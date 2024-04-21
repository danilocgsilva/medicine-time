<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Migrations\PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;

class PatientRepositoryTest extends TestCaseDB
{
    use PatientTrait;

    private PatientRepository $patientRepository;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->patientRepository = new PatientRepository($this->pdo);
    }
    
    public function testSaveAndRecover()
    {
        $this->renewByMigration(new PatientMigration());
        
        $patient = $this->createTestingPatient("John Doe");
        $this->patientRepository->save($patient);
        $listing = $this->patientRepository->list();

        $this->assertCount(1, $listing);
    }
}
