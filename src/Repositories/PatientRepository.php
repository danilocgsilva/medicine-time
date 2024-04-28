<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\PatientRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Patient;
use PDO;
use Danilocgsilva\MedicineTime\Migrations\M02MedicinePatientMigration;

class PatientRepository extends AbstractRepository implements PatientRepositoryInterface
{
    
    /** @inheritDoc */
    public function list(): array
    {
        $query = "SELECT id, name FROM " . Patient::TABLE_NAME . ";";
        $preResult = $this->pdo->prepare($query);
        $preResult->execute();
        $preResult->setFetchMode(PDO::FETCH_CLASS, Patient::class);

        /** @var \Danilocgsilva\MedicineTime\Entities\Patient[] */
        $list = [];
        while ($row = $preResult->fetch()) {
            $list[] = $row;
        }
        
        return $list;
    }

    public function save(Patient $patient): void
    {
        $patientRepositoryCreate = new PatientRepositoryCreate($this->pdo, $this);
        $patientRepositoryCreate->save($patient);
    }

    public function hasMedicineAssigment(Patient $patient): bool
    {
        $m02MedicinePatientMigration = new M02MedicinePatientMigration();

        $checkQuery = "SELECT COUNT(`id`) as count_id FROM %s;";
        $preResult = $this->pdo->prepare(
            sprintf(
                $checkQuery, 
                $m02MedicinePatientMigration->getTableName()
            )
        );

        $preResult->execute();
        $preResult->setFetchMode(PDO::FETCH_ASSOC);
        $row = $preResult->fetch();
        return (bool) (int) $row['count_id'];
    }
}
