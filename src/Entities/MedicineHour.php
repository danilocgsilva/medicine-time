<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class MedicineHour
{
    public const TABLE_NAME = "medicines_hour";

    /** @var int $id */
    public readonly int $id;

    public readonly string $hour;
}
