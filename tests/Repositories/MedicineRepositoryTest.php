<?php

declare(strict_types= 1);

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use PDO;
use Danilocgsilva\MedicineTime\Migrations\MedicinesMigration;

class MedicineRepositoryTest extends TestCase
{
    private MedicinesRepository $medicinesRepository;

    private PDO $pdo;

    public function setUp(): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', getenv('MEDICINE_TIME_DB_HOST'), getenv('MEDICINE_TIME_DB_NAME'));
        $this->pdo = new PDO($dsn, getenv('MEDICINE_TIME_DB_USERNAME'), getenv('MEDICINE_TIME_DB_PASSWORD'));
        
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
    }
    
    public function testSaveAndRecover()
    {
        $this->renewByMigration(new MedicinesMigration());
        
        $medicine = $this->createTestingMedicine("Cilostazol 100mg");
        $this->medicinesRepository->save($medicine);
        $listing = $this->medicinesRepository->list();

        $this->assertCount(1, $listing);
    }

    private function createTestingMedicine(string $medicineName): Medicine
    {
        $medicine = new Medicine();
        $medicine->setName($medicineName);
        return $medicine;
    }

    private function renewByMigration($entityMigration): void
    {
        $renewQuery = sprintf("USE %s;", getenv('MEDICINE_TIME_DB_NAME'));
        $renewQuery .= $entityMigration->getDownString();
        $renewQuery .= $entityMigration->getUpString();

        $preResult = $this->pdo->prepare($renewQuery);
        $preResult->execute();
    }
}
