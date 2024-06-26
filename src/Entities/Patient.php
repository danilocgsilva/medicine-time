<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Patient extends EntityAbstract
{
    public const TABLE_NAME = "patients";

    public readonly string $name;

    public array $medicines = [];

    public function setName(string $patientName): self
    {
        $this->name = $patientName;
        return $this;
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function assignMedicine(Medicine $medicine): self
    {
        $this->medicines[] = $medicine;
        return $this;
    }

    /**
     * Return a list of medicines for a patient
     *
     * @return \Danilocgsilva\MedicineTime\Entities\Medicine[]
     */
    public function getMedicinesRequired(): array
    {
        return $this->medicines;
    }
}
