<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Medicine
{
    public const TABLE_NAME = "Medicine";
    
    /** @var string $name */
    private string $name;
    
    /**
     * Get Medicine name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

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
}
