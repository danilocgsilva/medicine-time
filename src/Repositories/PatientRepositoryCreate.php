<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\PatientRepositoryInterface;
use Danilocgsilva\MedicineTime\Entities\Patient;
use PDO;
use Danilocgsilva\MedicineTime\Migrations\M02MedicinePatientMigration;

class PatientRepositoryCreate extends AbstractRepository
{
    private Patient $patient;

    private PatientRepositoryInterface $patientRepository;
    
    public function __construct(PDO $pdo, PatientRepositoryInterface $patientRepository)
    {
        parent::__construct($pdo);
        $this->patientRepository = $patientRepository;
    }
    
    public function save(Patient $patient)
    {
        $this->patient = $patient;

        $this->recordPatient();
        $this->recordMedicines();
    }

    private function recordPatient()
    {
        $insertQuery = 'INSERT INTO ' . Patient::TABLE_NAME . ' (name) VALUES (:name);';
        $preResult = $this->pdo->prepare($insertQuery);
        $preResult->execute([':name' => $this->patient->name]);
        $this->patient->setId((int) $this->pdo->lastInsertId());
    }

    private function recordMedicines()
    {
        $medicinesFromPatient = $this->patient->getMedicinesRequired();
        if (count($medicinesFromPatient) > 0) {

            $medicineAssigned = $medicinesFromPatient[0];
            
            $assigmentMedicineQuery = "INSERT INTO medicine_patient (medicine_id, patient_id) VALUES (:medicine_id, :patient_id);";
            $preResult = $this->pdo->prepare($assigmentMedicineQuery);
            $preResult->execute([
                ':medicine_id' => $medicineAssigned->getId(),
                ':patient_id' => $this->patient->getId()
            ]);
        }
    }
}