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


    /** @inheritDoc */
    public function findOccurrences(Medicine $medicine, Storage $storage): array
    {
        $medicineStorageQuery = "SELECT medicine_id, storage_id, remaining, register_time FROM %s WHERE medicine_id = :medicine_id AND storage_id = :storage_id;";
        $medicineStorageResults = $this->pdo->prepare(
            sprintf(
                $medicineStorageQuery,
                MedicineStorage::TABLE_NAME
            )
        );
        $medicineStorageResults->setFetchMode(PDO::FETCH_ASSOC);
        $medicineStorageResults->execute([
            ':medicine_id' => $medicine->getId(),
            ':storage_id' => $storage->getId()
        ]);
        $medicineStorageOccurrences = [];
        while ($row = $medicineStorageResults->fetch()) {
            $medicineStorageOccurrences[] = $this->buildMedicineStorageFromRow($row);
        }
        return $medicineStorageOccurrences;
    }

    private function buildMedicineStorageFromRow(array $row): MedicineStorage
    {
        return (new MedicineStorage())
            ->setMedicineId((int) $row["medicine_id"])
            ->setStorageId((int) $row["storage_id"])
            ->setRemaining((int) $row["remaining"])
            ->setRegisterTime(
                DateTime::createFromFormat("Y-m-d H:i:s", $row["register_time"])
            );
    }
}
