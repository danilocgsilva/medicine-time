<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Migrations\StorageMigration;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;

class StorageRepositoryTest extends TestCaseDB
{
    use StorageTrait;

    private StorageRepository $storageRepository;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->storageRepository = new StorageRepository($this->pdo);
    }
    
    public function testSaveAndRecover()
    {
        $this->renewByMigration(new StorageMigration());
        
        $storage = $this->createTestingStorage("default");
        $this->storageRepository->save($storage);
        $listing = $this->storageRepository->list();

        $this->assertCount(1, $listing);
    }
}
