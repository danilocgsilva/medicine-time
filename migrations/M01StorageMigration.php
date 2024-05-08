<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Storage;

class M01StorageMigration implements MigrationInterface
{
    /** @inheritDoc */
    public function getUpString(string $engine): string
    {
        $upString = <<<EOT
CREATE TABLE `%s` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(192) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=%s CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
EOT;
        
        return sprintf($upString, Storage::TABLE_NAME, $engine);
    }

    /** @inheritDoc */
    public function getDownString(): string
    {
        $downString = 'DROP TABLE IF EXISTS %s;';
        return sprintf($downString, Storage::TABLE_NAME);
    }

    /** @inheritDoc */
    public function getTableName(): string
    {
        return Storage::TABLE_NAME;
    }
}
