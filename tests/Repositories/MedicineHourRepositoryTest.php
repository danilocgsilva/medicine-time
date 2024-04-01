<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Migrations\MedicineHourMigration;
use Danilocgsilva\MedicineTime\Migrations\MedicinesMigration;

class MedicineHourRepositoryTest extends TestCaseDB
{
    use MedicineTrait;
    
    private MedicineHourRepository $medicineHourRepository;
    
    private MedicinesRepository $medicinesRepository;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->medicineHourRepository = new MedicineHourRepository($this->pdo);
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
    }
    
    public function testSave(): void
    {
        $this->renewByMigration(new MedicinesMigration());
        $this->renewByMigration(new MedicineHourMigration());
        
        $medicine = $this->createTestingMedicine("Alopurinol 40mg");
        $medicine->setId(5);
        $this->medicinesRepository->save($medicine);
        $this->medicineHourRepository->addManagementHour(9, $medicine);

        $justSavedMedicine = $this->medicinesRepository->list()[0];
        $this->assertSame(
            "09:00:00",
            $justSavedMedicine->getManagementHours()[0]
        );
    }
}
