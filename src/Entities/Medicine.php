<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;
use Danilocgsilva\MedicineTime\Repositories\Interfaces\MedicineRepositoryInterface;

class Medicine
{
    public const TABLE_NAME = "medicines";
    
    /** @var string $name */
    public readonly string $name;

    /** @var string $id */
    public readonly int $id;

    /**
     * Set medicine name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    
    public function addManagementHour(int $hour): self
    {
        return $this;
    }
}
