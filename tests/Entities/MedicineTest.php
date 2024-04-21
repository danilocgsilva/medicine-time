<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Entities;

use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Migrations\MedicinesMigration;

class MedicineTest extends TestCaseDB
{
    use MedicineTrait;
    
    public function setUp(): void
    {
        parent::setUp();
    }
    
    public function testAssertId1()
    {
        $this->renewByMigration(new MedicinesMigration());
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $medicinesRepository = new MedicinesRepository($this->pdo);
        $medicinesRepository->save($medicine);
        $lastInserId = (int) $this->pdo->lastInsertId();
        $recoveredMedicine = $medicinesRepository->list()[0];
        $this->assertSame($lastInserId, $recoveredMedicine->getId());
    }
}

