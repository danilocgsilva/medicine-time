<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\PatientRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Patient;
use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use PDO;
use Danilocgsilva\MedicineTime\Entities\MedicineHour;

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
        $checkQuery = "SELECT COUNT(`id`) as count_id FROM %s WHERE patient_id = :patient_id;";
        $preResult = $this->pdo->prepare(
            sprintf(
                $checkQuery, 
                MedicineHour::TABLE_NAME
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
     * When fetching patient list, patients may have medicines assigned to then.
     * This must reflects in the returned patient list.
     *
     * @param \Danilocgsilva\MedicineTime\Entities\Patient[]
     * @return void
     */
    private function assingMedicineAssigmentsToListMember(array &$patientsList): void
    {
        $getRelationShipQuery = sprintf(
            "SELECT medicine_id, patient_id FROM %s WHERE patient_id IN (%s);",
            MedicineHour::TABLE_NAME,
            implode(", ", array_map(fn ($entry) => $entry->getId(), $patientsList) )
        );
        $preResults = $this->pdo->prepare($getRelationShipQuery);
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
