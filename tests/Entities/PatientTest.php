<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Entities;

use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Migrations\M01PatientMigration;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;

class PatientTest extends TestCaseDB
{
    use PatientTrait;

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
}
