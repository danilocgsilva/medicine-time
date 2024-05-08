<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Patient;
use Danilocgsilva\MedicineTime\Entities\MedicineHour;

class M01MedicineHourMigration implements MigrationInterface
{
    /** @inheritDoc */
    public function getUpString(string $engine): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hour` TIME,
    `medicine_id` INT UNSIGNED NOT NULL,
    `patient_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=%s CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `%s` ADD CONSTRAINT `medicine_medicine_hour` FOREIGN KEY (`medicine_id`) REFERENCES `%s` (`id`);

ALTER TABLE `%s` ADD CONSTRAINT `medicine_hour_patient` FOREIGN KEY (`patient_id`) REFERENCES `%s` (`id`);
EOT;
        $migrationString = sprintf(
            $upString,
            MedicineHour::TABLE_NAME, 
            $engine,
            MedicineHour::TABLE_NAME,
            Medicine::TABLE_NAME,
            MedicineHour::TABLE_NAME,
            Patient::TABLE_NAME
        );
        return $migrationString;
    }

    /** @inheritDoc */
    public function getDownString(): string
    {
        $finalDownString = "";
        $downString = "ALTER TABLE `%s` DROP FOREIGN KEY `medicine_medicine_hour`;";
        $downString .= "\n" . "DROP TABLE IF EXISTS `%s`;";
        $finalDownString = sprintf($downString, MedicineHour::TABLE_NAME, MedicineHour::TABLE_NAME);
        return $finalDownString;
    }

    public function getTableName(): string
    {
        return MedicineHour::TABLE_NAME;
    }
}

