<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;

interface MedicineHourInterface
{
    /**
     * Add a management hour for an given Medicine
     *
     * @param integer $hour
     * @return self
     */
    public function addManagementHour(int $hour, Medicine $medicine, Patient $patient): self;

    /**
     * Fetches the medicine managemente hour.
     *
     * @param Medicine $medicine
     * @return string
     */
    public function getManagementHours(Medicine $medicine): array;
}
