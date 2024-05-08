<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Entities;

use Danilocgsilva\MedicineTime\Tests\Commons\StorageTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Migrations\M01StorageMigration;
use Danilocgsilva\MedicineTime\Repositories\StorageRepository;

class StorageTest extends TestCaseDB
{
    use StorageTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testAssertId1()
    {
        $this->renewByMigration(new M01StorageMigration(), $this->dbEngine);
        $storage = $this->createTestingStorage("default");
        $storageRepository = new StorageRepository($this->pdo);
        $storageRepository->save($storage);
        $lastInsertId = (int) $this->pdo->lastInsertId();
        $recoveredStorage = $storageRepository->list()[0];
        $this->assertSame($lastInsertId, $recoveredStorage->getId());
    }
}
