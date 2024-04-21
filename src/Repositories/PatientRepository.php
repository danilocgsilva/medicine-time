<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\PatientRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Patient;
use PDO;

class PatientRepository extends AbstractRepository implements PatientRepositoryInterface
{
    
    /** @inheritDoc */
    public function list(): array
    {
        $query = "SELECT id, name FROM " . Patient::TABLE_NAME . ";";
        $preResult = $this->pdo->prepare($query);
        $preResult->execute();
        $preResult->setFetchMode(PDO::FETCH_CLASS, Patient::class);

        $list = [];
        while ($row = $preResult->fetch()) {
            $list[] = $row;
        }
        
        return $list;
    }

    public function save(Patient $patient): void
    {
        $insertQuery = 'INSERT INTO ' . Patient::TABLE_NAME . ' (name) VALUES (:name);';
        $preResult = $this->pdo->prepare($insertQuery);
        $preResult->execute([':name' => $patient->name]);
        $patient->setId((int) $this->pdo->lastInsertId());
    }
}
