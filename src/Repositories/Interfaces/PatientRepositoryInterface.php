<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;

interface PatientRepositoryInterface
{
    /**
     * List all patients
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\Patient[]
     */
    public function list(): array;

    /**
     * Save a patient to the database.
     *
     * @param Patient $patient
     * @return void
     */
    public function save(Patient $patient): void;

    /**
     * Check if is the medicine alerady assigned to the patient.
     *
     * @param Patient $patient
     * @return boolean
     */
    public function hasMedicineAssigment(Patient $patient): bool;
}
