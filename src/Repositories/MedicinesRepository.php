<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineRepositoryInterface;
use PDO;
use Danilocgsilva\MedicineTime\Entities\Medicine;

class MedicinesRepository extends AbstractRepository implements MedicineRepositoryInterface
{
    /** @inheritdoc */
    public function list(): array
    {
        $query = "SELECT id, name FROM " . Medicine::TABLE_NAME . ";";
        $preResult = $this->pdo->prepare($query);
        $preResult->execute();
        $preResult->setFetchMode(PDO::FETCH_CLASS, Medicine::class);

        $list = [];
        while ($row = $preResult->fetch()) {
            $list[] = $row;
        }
        
        return $list;
    }

    /** @inheritDoc */
    public function save(Medicine $medicine): void
    {
        $insertQuery = 'INSERT INTO ' . Medicine::TABLE_NAME . ' (name) VALUES (:name);';
        $preResult = $this->pdo->prepare($insertQuery);
        $preResult->execute([':name' => $medicine->name]);
    }
}
