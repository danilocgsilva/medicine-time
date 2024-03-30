<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

class MedicinesMigration
{
    public function getUpString(): string
    {
        $upString = EOT<<<
"CREATE TABLE `medicine` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(192) NOT NULL
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;"
EOT;
        return $upString;
    }
}
