<?php

declare(strict_types= 1);

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MedicineTime\Repositories\MedicineTimeRepository;
use Danilocgsilva\MedicineTime\Entities\Medicine;

class MedicineRepositoryTest extends TestCase
{
    private MedicineTimeRepository $medicineTimeRepository;
    
    public function setUp(): void
    {
        $this->medicineTimeRepository = new MedicineTimeRepository();
    }
    
    public function testSaveAndRecover()
    {
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $this->medicineTimeRepository->save($medicine);
    }

    private function createTestingMedicine(string $medicineName): Medicine
    {
        $medicine = new Medicine();
        $medicine->setName($medicineName);
        return $medicine;
    }
}
