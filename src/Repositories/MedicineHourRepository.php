<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineHourInterface;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\MedicineHour;

class MedicineHourRepository extends AbstractRepository implements MedicineHourInterface
{
    /** @inheritDoc */
    public function addManagementHour(int $hour, Medicine $medicine): self
    {
        $stringHour = $hour . ":00:00";
        $inserQuery = "INSERT INTO %s (hour, medicine_id) VALUES (:hour, :medicine_id);";
        $preResults = $this->pdo->prepare(sprintf($inserQuery, MedicineHour::TABLE_NAME));
        $preResults->execute([ ':hour' => $stringHour, ':medicine_id' => $medicine->id ]);
        return $this;
    }

    public function getMenagementHour(Medicine $medicine): string
    {
        $query = "SELECT ";
        return "";
    }
}
