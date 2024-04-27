<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests;

use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;

class PreviewTest extends TestCaseDB
{
    use StorageTrait, MedicineTrait;

    public function testRemainingInDays()
    {
        $this->renewByMigration(new M01StorageMigration());
        $storage = $this->createTestingStorage("default");

        $this->renewByMigration(new M01MedicinesMigration());
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");

        $this->assertSame(0, 0);
    }

    private function 
}

