<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;

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
    `patient_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `%s` ADD CONSTRAINT `medicine_medicine_id` FOREIGN KEY (`medicine_id`) REFERENCES `%s` (`id`);

ALTER TABLE `%s` ADD CONSTRAINT `patient_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `%s` (`id`);
EOT;

        $finalUpString = sprintf($upString, self::TABLE_NAME, self::TABLE_NAME, Medicine::TABLE_NAME, self::TABLE_NAME, Patient::TABLE_NAME);

        return $finalUpString;
    }
}
