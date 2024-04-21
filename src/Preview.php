<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime;

use Danilocgsilva\MedicineTime\Entities\Medicine;

class Preview
{
    public function remainingInDays(array $storages, Medicine $medicine, array $patients): int
    {
        return 0;
    }
}
