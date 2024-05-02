<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;
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
        $this->renewByMigration(new M01MedicinesMigration());
        $this->storeTestingMedicine("Cilostazol 100mg");
        $listing = $this->medicinesRepository->list();
        $this->assertCount(1, $listing);
    }

    public function testFindManyByIdsOneMedicine()
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $medicine = $this->storeTestingMedicine("Cilostazol 100mg");
        $listing = $this->medicinesRepository->findManyByIds([$medicine->getId()]);
        $this->assertCount(1, $listing);
    }

    public function testFindManyByIdsThreeMedicines()
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $medicine1 = $this->storeTestingMedicine("Cilostazol 100mg");
        $medicine2 = $this->storeTestingMedicine("Levotiroxina Sódica (50mcg)");
        $listing = $this->medicinesRepository->findManyByIds([
            $medicine1->getId(),
            $medicine2->getId()
        ]);

        $this->assertCount(2, $listing);
    }

    public function testFindByKey()
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $this->storeTestingMedicine("Cilostazol 100mg");
        $recoveredMedicine = $this->medicinesRepository->findById(1);
        $this->assertSame(1, $recoveredMedicine->getId());
        $this->assertSame("Cilostazol 100mg", $recoveredMedicine->getName());
    }
}
