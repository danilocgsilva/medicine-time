<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\MedicineStorage;
use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Entities\Storage;

class M02MedicineStorageMigration implements MigrationInterface
{   
    public function getDownString(): string
    {
        $downString = 'DROP TABLE IF EXISTS %s;';
        return sprintf($downString, MedicineStorage::TABLE_NAME);
    }

    public function getTableName(): string
    {
        return MedicineStorage::TABLE_NAME;
    }

    public function getUpString(): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `medicine_id` INT UNSIGNED NOT NULL,
    `storage_id` INT UNSIGNED NOT NULL,
    `remaining` INT NOT NULL,
    `register_time` DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

ALTER TABLE `%s` ADD CONSTRAINT `medicine_constraint` FOREIGN KEY (`medicine_id`) REFERENCES `%s` (`id`);

ALTER TABLE `%s` ADD CONSTRAINT `storage_constraint` FOREIGN KEY (`storage_id`) REFERENCES `%s` (`id`);
EOT;

        return sprintf(
            $upString, 
            MedicineStorage::TABLE_NAME, 
            MedicineStorage::TABLE_NAME,
            Medicine::TABLE_NAME,
            MedicineStorage::TABLE_NAME,
            Storage::TABLE_NAME
        );
    }
}
