<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Migrations\MedicineHourMigration;

class MedicineHourRepositoryTest extends TestCaseDB
{
    use MedicineTrait;
    
    private MedicineHourRepository $medicineHourRepository;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->medicineHourRepository = new MedicineHourRepository($this->pdo);
    }
    
    public function testSave(): void
    {
        $this->renewByMigration(new MedicineHourMigration());
        
        $medicine = $this->createTestingMedicine("Alopurinol 40mg");
        $medicine->setId(5);
        $this->medicineHourRepository->addManagementHour(9, $medicine);
    }
}
