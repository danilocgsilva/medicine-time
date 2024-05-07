<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Entities;

use DateTime;

class MedicineStorage extends EntityAbstract
{
    public const TABLE_NAME = "medicine_storage";

    public readonly int $medicine_id;

    public readonly int $storage_id;

    public readonly int $remaining;

    public readonly DateTime $register_time;

    public function setRemaining(int $remaining): MedicineStorage
    {
        $this->remaining = $remaining;
        return $this;
    }

    public function setRegisterTime(DateTime $registerTime): MedicineStorage
    {
        $this->register_time = $registerTime;
        return $this;
    }

    public function getRegisterTime(): DateTime
    {
        return $this->register_time;
    }

    public function setMedicineId(int $id): self
    {
        $this->medicine_id = $id;
        return $this;
    }

    public function setStorageId(int $id): self
    {
        $this->storage_id = $id;
        return $this;
    }
}
