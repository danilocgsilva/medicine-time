<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Commons;

use Danilocgsilva\MedicineTime\Entities\Patient;

trait PatientTrait
{
    protected function createTestingPatient(string $patientName): Patient
    {
        $patient = new Patient();
        $patient->setName($patientName);
        return $patient;
    }

    protected function storeTestingPatient(string $patientName): Patient
    {
        $testingPatient = $this->createTestingPatient($patientName);
        $this->patientRepository->save($testingPatient);
        return $testingPatient;
    }
}
