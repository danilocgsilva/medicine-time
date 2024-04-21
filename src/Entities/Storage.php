<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Storage extends EntityAbstract
{
    public const TABLE_NAME = "storage";

    public readonly string $name;

    /**
     * Returns the storage name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function remainignPills(): int
    {

    }
}
