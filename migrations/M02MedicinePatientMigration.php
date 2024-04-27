<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

class M02MedicinePatientMigration implements MigrationInterface
{
    private const TABLE_NAME = "medicine_patient";

    public function getDownString(): string
    {
        $downString = 'DROP TABLE IF EXISTS %s;';
        return sprintf($downString, self::TABLE_NAME);
    }

    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public function getUpString(): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `medicine_id` INT UNSIGNED NOT NULL,
    `patient_id` INT UNSIGNED NOT NULL
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
EOT;

        return sprintf($upString, self::TABLE_NAME);
    }
}
