<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

use DateTime;

class MedicineStorage extends EntityAbstract
{
    public const TABLE_NAME = "medicine_storage";

    public readonly int $medicine_id;

    public readonly int $storage_id;

    public readonly int $remaining;

    public readonly DateTime $register_time;
}
