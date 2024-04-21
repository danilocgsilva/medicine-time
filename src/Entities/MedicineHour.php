<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class MedicineHour extends EntityAbstract
{
    public const TABLE_NAME = "medicines_hour";

    public readonly string $hour;
}
