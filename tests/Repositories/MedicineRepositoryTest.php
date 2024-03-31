<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Migrations\MedicinesMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;

class MedicineRepositoryTest extends TestCaseDB
{
    use MedicineTrait;

    private MedicinesRepository $medicinesRepository;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
    }
    
    public function testSaveAndRecover()
    {
        $this->renewByMigration(new MedicinesMigration());
        
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $this->medicinesRepository->save($medicine);
        $listing = $this->medicinesRepository->list();

        $this->assertCount(1, $listing);
    }
}
