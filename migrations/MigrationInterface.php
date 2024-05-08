<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Migrations;

use Danilocgsilva\MedicineTime\Entities\Medicine;

interface MigrationInterface
{
    /**
     * Get the up string into application
     *
     * @return string
     */
    public function getUpString(string $engine): string;

    /**
     * Get down/revert string query into application
     *
     * @return string
     */
    public function getDownString(): string;

    /**
     * Get the table name
     *
     * @return string
     */
    public function getTableName(): string;
}
