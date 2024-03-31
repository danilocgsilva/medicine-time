<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Commons;

use Danilocgsilva\MedicineTime\Entities\Medicine;

trait MedicineTrait
{
    protected function createTestingMedicine(string $medicineName): Medicine
    {
        $medicine = new Medicine();
        $medicine->setName($medicineName);
        return $medicine;
    }
}
