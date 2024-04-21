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
}
