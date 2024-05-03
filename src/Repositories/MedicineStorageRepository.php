<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineStorageRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Storage;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\MedicineStorage;
use DateTime;
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
     * @param Storage $storage   The storage
     * @param Medicine $medicine The medicine
     * @param DateTime $datetime A date for consuting
     * @return integer
     */
    public function getRemainingPills(Storage $storage, Medicine $medicine, DateTime $datetime = new DateTime()): int
    {
        $query = 'SELECT remaining, register_time FROM %s WHERE medicine_id = :medicine_id AND storage_id = :storage_id;';
        $preResult = $this->pdo->prepare(sprintf($query, MedicineStorage::TABLE_NAME));
        $preResult->setFetchMode(PDO::FETCH_ASSOC);
        $preResult->execute([
            ':medicine_id' => $medicine->getId(),
            ':storage_id' => $storage->getId()
        ]);
        /** @var array */
        $remainingRow = $preResult->fetch();

        $remaining = $this->generateMedicineStorageFromFields($remainingRow);

        if ($datetime === "") {
            return $remaining->remaining;
        }

        $interval = $datetime->diff($remaining->register_time);

        return $remaining->remaining - $interval->format('%a');
    }

    private function generateMedicineStorageFromFields(array $row): MedicineStorage
    {
        $remaining = new MedicineStorage();
        $remaining->setRemaining((int) $row['remaining']);
        $registerDateTime = DateTime::createFromFormat(
            'Y-m-d H:i:s',
            $row['register_time']
        );
        $remaining->setRegisterTime($registerDateTime);
        return $remaining;
    }
}
