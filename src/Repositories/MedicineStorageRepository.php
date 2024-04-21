<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineStorageRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Storage;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\MedicineStorage;
use PDO;

class MedicineStorageRepository extends AbstractRepository implements MedicineStorageRepositoryInterface
{
    public function setRemainingPills(Storage $storage, Medicine $medicine, int $pillsCount): void
    {
        $queryBase = 'INSERT INTO %s (medicine_id, storage_id, remaining) VALUES (:medicine_id, :storage_id, :remaining);';
        $query = sprintf($queryBase, MedicineStorage::TABLE_NAME);
        $preResult = $this->pdo->prepare($query);
        $preResult->execute([
            ':medicine_id' => $medicine->getId(),
            ':storage_id' => $storage->getId(),
            ':remaining' => $pillsCount
        ]);
    }
    
    public function getRemainingPills(Storage $storage, Medicine $medicine): int
    {
        $query = 'SELECT remaining FROM %s WHERE medicine_id = :medicine_id AND storage_id = :storage_id;';
        $preResult = $this->pdo->prepare(sprintf($query, MedicineStorage::TABLE_NAME));
        $preResult->setFetchMode(PDO::FETCH_CLASS, MedicineStorage::class);
    }
}
