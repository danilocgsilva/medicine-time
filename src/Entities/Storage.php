<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

class Storage
{
    /** @var string $id */
    public readonly int $id;

    public const TABLE_NAME = "storage";

    public readonly string $name;

    /**
     * Set it to storage. So in the last id insertion, the object can have consistency in its data.
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
