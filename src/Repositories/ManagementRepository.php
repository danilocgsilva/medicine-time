<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;

class ManagementRepository extends AbstractRepository
{
    public function addManagementHour(int|string $managementHour, Medicine $medicine, Patient $patient)
    {

    }
}
