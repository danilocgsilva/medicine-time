<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Commons;

use Danilocgsilva\MedicineTime\Migrations\MigrationInterface;
use PHPUnit\Framework\TestCase;
use PDO;

class TestCaseDB extends TestCase
{
    protected PDO $pdo;

    public function setUp(): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', getenv('MEDICINE_TIME_DB_HOST'), getenv('MEDICINE_TIME_DB_NAME'));
        $this->pdo = new PDO($dsn, getenv('MEDICINE_TIME_DB_USERNAME'), getenv('MEDICINE_TIME_DB_PASSWORD'));
    }

    /**
     * Whipe out a table from a give migration
     *
     * @param \Danilocgsilva\MedicineTime\Migrations\MigrationInterface $entityMigration
     * @return void
     */
    protected function renewByMigration(MigrationInterface $entityMigration): void
    {
        $renewQuery = sprintf("USE %s;", getenv('MEDICINE_TIME_DB_NAME'));
        $renewQuery .= $entityMigration->getDownString();
        $renewQuery .= $entityMigration->getUpString();

        $preResult = $this->pdo->prepare($renewQuery);
        $preResult->execute();
    }
}

