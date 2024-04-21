<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Patient;

interface PatientRepositoryInterface
{
    /**
     * List all patients
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\Patient[]
     */
    public function list(): array;

    public function save(Patient $patient): void;
}
