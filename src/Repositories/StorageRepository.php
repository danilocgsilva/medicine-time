<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\StorageRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Storage;
use PDO;

class StorageRepository extends AbstractRepository implements StorageRepositoryInterface
{
    
    /** @inheritDoc */
    public function list(): array
    {
        $query = "SELECT id, name FROM " . Storage::TABLE_NAME . ";";
        $preResult = $this->pdo->prepare($query);
        $preResult->execute();
        $preResult->setFetchMode(PDO::FETCH_CLASS, Storage::class);

        $list = [];
        while ($row = $preResult->fetch()) {
            $list[] = $row;
        }
        
        return $list;
    }
}
