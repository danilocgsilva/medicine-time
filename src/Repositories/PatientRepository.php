<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\PatientRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Patient;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
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
        $patientList = [];
        while ($row = $preResult->fetch()) {
            $patientList[] = $row;
        }

        $this->assingMedicineAssigmentsToListMember($patientList);
        
        return $patientList;
    }

    /** @inheritDoc */
    public function save(Patient $patient): void
    {
        $patientRepositoryCreate = new PatientRepositoryCreate($this->pdo, $this);
        $patientRepositoryCreate->save($patient);
    }

    /** @inheritDoc */
    public function hasMedicineAssigment(Patient $patient): bool
    {
        $m02MedicinePatientMigration = new M02MedicinePatientMigration();

        $checkQuery = "SELECT COUNT(`id`) as count_id FROM %s WHERE patient_id = :patient_id;";
        $preResult = $this->pdo->prepare(
            sprintf(
                $checkQuery, 
                $m02MedicinePatientMigration->getTableName()
            )
        );

        $preResult->execute([
            ':patient_id' => $patient->getId()
        ]);
        $preResult->setFetchMode(PDO::FETCH_ASSOC);
        $row = $preResult->fetch();
        return (bool) (int) $row['count_id'];
    }

    /**
     * Undocumented function
     *
     * @param \Danilocgsilva\MedicineTime\Entities\Patient[]
     * @return void
     */
    private function assingMedicineAssigmentsToListMember(array &$patientsList)
    {
        $patientIds = [];
        foreach ($patientsList as $patient) {
            $patientIds[] = $patient->getId();
        }
        $checkAssignedMedicinesQuery = sprintf(
            "SELECT medicine_id, patient_id FROM %s WHERE patient_id IN (%s);", 
            (new M02MedicinePatientMigration())->getTableName(), 
            implode(", ", $patientIds)
        );
        $preResults = $this->pdo->prepare($checkAssignedMedicinesQuery);
        $preResults->execute();
        $preResults->setFetchMode(PDO::FETCH_ASSOC);
        $medicineRepository = new MedicinesRepository($this->pdo);
        while ($row = $preResults->fetch()) {
            $patientArrayKey = $this->getPatientArrayKey((int) $row['patient_id'], $patientsList);
            $medicine = $medicineRepository->findById((int) $row['medicine_id']);
            $patientsList[$patientArrayKey]->assignMedicine($medicine);
        }
    }

    private function getPatientArrayKey(int $id, array $patients): int|null
    {
        foreach ($patients as $key => $patient) {
            if ($patient->getId() === $id) {
                return $key;
            }
        }
        return null;
    }
}
