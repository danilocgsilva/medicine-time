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
    /**
     * Informs to the system the pills amount for a defined medicine in a give storage.
     *
     * @param Storage $storage
     * @param Medicine $medicine
     * @param integer $pillsCount
     * @return void
     */
    public function setRemainingPills(Storage $storage, Medicine $medicine, int $pillsCount, string $datatime = ""): void
    {
        $queryBase = "";
        if ($datatime === "") {
            $queryBase = 'INSERT INTO %s (medicine_id, storage_id, remaining) VALUES (:medicine_id, :storage_id, :remaining);';
        } else {
            $queryBase = 'INSERT INTO %s (medicine_id, storage_id, remaining, register_time) VALUES (:medicine_id, :storage_id, :remaining, :register_time);';
        }
        $query = sprintf($queryBase, MedicineStorage::TABLE_NAME);
        $preResult = $this->pdo->prepare($query);

        $baseExecuteParameters = [
            ':medicine_id' => $medicine->getId(),
            ':storage_id' => $storage->getId(),
            ':remaining' => $pillsCount
        ];

        if ($datatime !== "") {
            $baseExecuteParameters['register_time'] = $datatime;
        }
        
        $preResult->execute($baseExecuteParameters);
    }
    
    /**
     * Gets the remaining amount of medicine, given the storage and the mecicine.
     *
     * @param Storage $storage
     * @param Medicine $medicine
     * @return integer
     */
    public function getRemainingPills(Storage $storage, Medicine $medicine, string $datetime = ""): int
    {
        $query = 'SELECT remaining FROM %s WHERE medicine_id = :medicine_id AND storage_id = :storage_id;';
        $preResult = $this->pdo->prepare(sprintf($query, MedicineStorage::TABLE_NAME));
        $preResult->setFetchMode(PDO::FETCH_CLASS, MedicineStorage::class);
        $preResult->execute([
            ':medicine_id' => $medicine->getId(),
            ':storage_id' => $storage->getId()
        ]);
        /** @var \Danilocgsilva\MedicineTime\Entities\MedicineStorage */
        $remainingRow = $preResult->fetch();

        if ($datetime === "") {
            return $remainingRow->remaining;
        }

        throw new \Exception("Still being implemented.");
    }
}
