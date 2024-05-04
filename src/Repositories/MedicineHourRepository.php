<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineHourInterface;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;
use Danilocgsilva\MedicineTime\Entities\MedicineHour;
use PDO;

class MedicineHourRepository extends AbstractRepository implements MedicineHourInterface
{
    /** @inheritDoc */
    public function addManagementHour(int $hour, Medicine $medicine, Patient $patient): self
    {
        $stringHour = $hour . ":00:00";
        $inserQuery = "INSERT INTO %s (hour, medicine_id, patient_id) VALUES (:hour, :medicine_id, :patient_id);";
        $preResults = $this->pdo->prepare(sprintf($inserQuery, MedicineHour::TABLE_NAME));
        $preResults->execute([
            ':hour' => $stringHour, 
            ':medicine_id' => $medicine->getId(),
            ':patient_id' => $patient->getId()
        ]);
        return $this;
    }

    public function getManagementHours(Medicine $medicine): array
    {
        $query = "SELECT hour FROM %s WHERE medicine_id = :medicine_id;";
        $preReresults = $this->pdo->prepare(sprintf($query, MedicineHour::TABLE_NAME));
        $preReresults->execute([':medicine_id' => $medicine->getId()]);
        $preReresults->setFetchMode(PDO::FETCH_CLASS, MedicineHour::class);
        $hours = [];
        while ($row = $preReresults->fetch()) {
            $hours[] = $row;
        }

        return $hours;
    }
}
