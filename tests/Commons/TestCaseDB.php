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
        $renewQuery .= "\n" . "SET FOREIGN_KEY_CHECKS=0;";
        if ($this->tableExists($entityMigration->getTableName())) {
            $renewQuery .= "\n" . $entityMigration->getDownString();
        }
        $renewQuery .= "\n" . $entityMigration->getUpString();
        $renewQuery .= "\n" . "SET FOREIGN_KEY_CHECKS=1;";

        $preResult = $this->pdo->prepare($renewQuery);
        $preResult->execute();
    }

    private function tableExists(string $tableName): bool
    {
        $checkQuery = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = :table_schema AND TABLE_TYPE = :table_type AND TABLE_NAME = :table_name;";
        $preResults = $this->pdo->prepare($checkQuery);
        $preResults->execute([
            ':table_schema' => getenv('MEDICINE_TIME_DB_NAME'),
            ':table_type' => 'BASE TABLE',
            ':table_name' => $tableName
        ]);
        
        return (bool) $preResults->fetch(PDO::FETCH_ASSOC);
    }
}

