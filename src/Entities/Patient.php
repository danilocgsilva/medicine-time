<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Patient
{
    /** @var int $id */
    public readonly int $id;

    public const TABLE_NAME = "patients";
}
