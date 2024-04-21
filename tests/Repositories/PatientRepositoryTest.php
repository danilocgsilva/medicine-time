<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
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
        $this->renewByMigration(new M01PatientMigration());
        
        $patient = $this->createTestingPatient("John Doe");
        $this->patientRepository->save($patient);
        $listing = $this->patientRepository->list();

        $this->assertCount(1, $listing);
    }
}
