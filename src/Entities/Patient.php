<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Patient extends EntityAbstract
{
    public const TABLE_NAME = "patients";

    public readonly string $name;

    public function setName(string $patientName): self
    {
        $this->name = $patientName;
        return $this;
    }

    public function getId(): int
    {
        return (int) $this->id;
    }
}
