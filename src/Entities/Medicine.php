<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Medicine extends EntityAbstract
{
    public const TABLE_NAME = "medicines";
    
    /** @var string $name */
    public readonly string $name;
    

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return (int) $this->id;
    }
}
