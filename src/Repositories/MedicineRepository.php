<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineRepositoryInterface;
use PDO;

class MedicineTimeRepository implements MedicineRepositoryInterface
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /** @inheritdoc */
    public function list(): array
    {
        $query = "SELECT"
        
        return [];
    }

    public function create(array $data): MedicineTime
    {

    }
}
