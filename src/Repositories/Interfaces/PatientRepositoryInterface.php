<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

interface PatientRepositoryInterface
{
    /**
     * List all patients
     * 
     * @return \Danilocgsilva\MedicineTime\Entities\Patient[]
     */
    public function list(): array;
}
