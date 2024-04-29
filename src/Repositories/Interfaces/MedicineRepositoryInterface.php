<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime\Repositories\Interfaces;

use Danilocgsilva\MedicineTime\Entities\Medicine;

interface MedicineRepositoryInterface
{
    /**
     * List of medicines
     *
     * @return \Danilocgsilva\MedicineTime\Entities\Medicine[]
     */
    public function list(): array;

    /**
     * Register a medicine in the database
     *
     * @param Medicine $medicine
     * @return void
     */
    public function save(Medicine $medicine): void;

    /**
     * Return several medicines at once, after receiving the ids.
     *
     * @param array $ids
     * @return \Danilocgsilva\MedicineTime\Entities\Medicine[]
     */
    public function findManyByIds(array $ids): array;

    /**
     * Find a medicine from database by key
     *
     * @param integer $id
     * @return Medicine
     */
    public function findById(int $id): Medicine;
}
