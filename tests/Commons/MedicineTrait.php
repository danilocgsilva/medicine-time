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

    protected function storeTestingMedicine(string $medicineName): Medicine
    {
        $medicine = $this->createTestingMedicine($medicineName);
        $this->medicinesRepository->save($medicine);
        return $medicine;
    }
}
