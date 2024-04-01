<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\MedicineHour;

class MedicineHourMigration implements MigrationInterface
{
    /** @inheritDoc */
    public function getUpString(): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `hour` TIME NOT NULL,
    `medicine_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `%s` ADD CONSTRAINT `medicine_medicine_hour` FOREIGN KEY (`medicine_id`) REFERENCES `%s` (`id`);
EOT;
        $migrationString = sprintf($upString, MedicineHour::TABLE_NAME, MedicineHour::TABLE_NAME, Medicine::TABLE_NAME);
        return $migrationString;
    }

    /** @inheritDoc */
    public function getDownString(): string
    {
        $downString = "ALTER TABLE `%s` DROP FOREIGN KEY `medicine_medicine_hour`;";
        $downString .= "\n" . "DROP TABLE IF EXISTS `%s`;";
        return sprintf($downString, MedicineHour::TABLE_NAME, MedicineHour::TABLE_NAME);
    }
}

