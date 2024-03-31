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
        $inserQuery = "INSERT INTO %s (hour, medicine_id) VALUES (:hour, :medicine_id);";
        $preResults = $this->pdo->prepare(sprintf($inserQuery, MedicineHour::TABLE_NAME));
        $preResults->execute([ ':hour' => $hour, ':medicine_id' => $medicine->id ]);
        return $this;
    }
}
