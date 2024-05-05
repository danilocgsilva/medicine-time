<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use DateTime;
use Exception;

class Preview
{
    public function remainingInDays(array $storages, Medicine $medicine, array $patients): int
    {
        return 0;
    }

    /**
     * Checks the amount of a given medicine consumed by a period.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @param Medicine $medicine
     * @param MedicineHourRepository $medicineHourRepository
     * @return int
     */
    public function consumingByPeriod(
        DateTime $start, 
        DateTime $end, 
        Medicine $medicine, 
        MedicineHourRepository $medicineHourRepository
    ): int
    {
        if ($end < $start) {
            throw new Exception("The end date must stay after the start date.");
        }

        $countConsumed = 0;
        $interval = date_diff($end, $start);
        $containingDaysInInterval = (int) $interval->format('%a') + 1;
        /** @var \Danilocgsilva\MedicineTime\Entities\MedicineHour[] */
        $occurrences = $medicineHourRepository->getManagementHours($medicine);

        $countConsumed += count($occurrences) * $containingDaysInInterval;
        return 123;
    }
}
