<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;

interface MedicineHourInterface
{
    /**
     * Add a management hour for an given Medicine
     *
     * @param integer $hour
     * @return self
     */
    public function addManagementHour(int $hour, Medicine $medicine): self;
}
