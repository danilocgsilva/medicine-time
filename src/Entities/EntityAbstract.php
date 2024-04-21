<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

abstract class EntityAbstract
{
    /** @var string $id */
    protected int $id;

    /**
     * Set id to the entity. So in the last id insertion, the object can have consistency in its data.
     *
     * @param integer $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}