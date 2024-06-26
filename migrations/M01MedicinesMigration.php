<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Medicine;

class M01MedicinesMigration implements MigrationInterface
{
    /** @inheritDoc */
    public function getUpString(string $engine): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(192) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
EOT;

        return sprintf($upString, Medicine::TABLE_NAME);
    }

    /** @inheritDoc */
    public function getDownString(): string
    {
        $downString = 'DROP TABLE IF EXISTS %s;';
        return sprintf($downString, Medicine::TABLE_NAME);
    }

    /** @inheritDoc */
    public function getTableName(): string
    {
        return Medicine::TABLE_NAME;
    }
}
