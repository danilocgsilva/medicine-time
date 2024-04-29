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
        $medicine->setId((int) $this->pdo->lastInsertId());
    }

    /** @inheritDoc */
    public function findManyByIds(array $ids): array
    {
        $searchQuery = "SELECT id, name FROM " . Medicine::TABLE_NAME . " WHERE id IN (" . implode(", ", $ids) . ");";
        $preResults = $this->pdo->prepare($searchQuery);
        $preResults->execute();
        $preResults->setFetchMode(PDO::FETCH_CLASS, Medicine::class);

        $medicineList = [];
        while ($row = $preResults->fetch()) {
            $medicineList[] = $row;
        }

        return $medicineList;
    }

    /** @inheritDoc */
    public function findById(int $id): Medicine
    {
        $searchQuery = "SELECT id, name FROM " . Medicine::TABLE_NAME . " WHERE id = :id;";
        $preResults = $this->pdo->prepare($searchQuery);
        $preResults->execute([':id' => $id]);
        $preResults->setFetchMode(PDO::FETCH_CLASS, Medicine::class);
        return $preResults->fetch();
    }
}
