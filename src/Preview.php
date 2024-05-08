<?php

declare(strict_types=1);

namespace Danilocgsilva\MedicineTime;

use Danilocgsilva\MedicineTime\Entities\Medicine;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use Danilocgsilva\MedicineTime\Entities\Storage;
use Danilocgsilva\MedicineTime\Repositories\MedicineStorageRepository;
use DateTime;
use Exception;

class Preview
{
    public function __construct(
        private MedicineHourRepository $medicineHourRepository,
    ) {}
    
    public function remainingInDays(
        array $storages, 
        Medicine $medicine, 
        array $patients, 
        MedicineStorageRepository $medicineStorageRepository,
        DateTime $dateTime = new DateTime()
    ): int
    {
        /** @var \Danilocgsilva\MedicineTime\Entities\MedicineHour[] */
        $medicineHoursOccurrences = $this->medicineHourRepository->getManagementHours($medicine);

        /** @var \Danilocgsilva\MedicineTime\Entities\MedicineStorage[] */
        $medicineStorageOccurrences = $medicineStorageRepository->findOccurrences($medicine, $storages[0]);

        return $medicineStorageOccurrences[0]->remaining;
    }

    /**
     * Checks the amount of a given medicine consumed by a period.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @param Medicine $medicine
     * @return int
     */
    public function consumingByPeriod(
        DateTime $start, 
        DateTime $end, 
        Medicine $medicine
    ): int
    {
        if ($end < $start) {
            throw new Exception("The end date must stay after the start date.");
        }

        $countConsumed = 0;
        /** @var \Danilocgsilva\MedicineTime\Entities\MedicineHour[] */
        $occurrences = $this->medicineHourRepository->getManagementHours($medicine);
        $ocurrenceHour = $occurrences[0]->hour;
        $firstHour = (int) substr($ocurrenceHour, 0, 6);
        if ($firstHour > (int) $start->format("H")) {
            $countConsumed++;
        }

        $lastHour = $firstHour;
        if (count($occurrences) === 1) {
            if ($lastHour > (int) $end->format("H")) {
                $countConsumed--;
                return $countConsumed;
            }
        }
        
        return $countConsumed;
    }

    /**
     * Get remaining pills from storage
     *
     * @param Storage $storage
     * @param Medicine $medicine
     * @param MedicineStorageRepository $medicineStorageRepository
     * @param MedicineHourRepository $medicineHourRepository,
     * @param DateTime $dateTime = new DateTime()
     * 
     * @param DateTime $dateTime
     * @return integer
     */
    public function getRemainingPills(
        Storage $storage, 
        Medicine $medicine,
        MedicineStorageRepository $medicineStorageRepository,
        DateTime $dateTime = new DateTime()
    ): int
    {
        $occurrences = $medicineStorageRepository->findOccurrences($medicine, $storage);
        $interval = $occurrences[0]->register_time->diff($dateTime);
        $intervalDays = $interval->format('%a');

        $occurrencesManagementHours = $this->medicineHourRepository->getManagementHours($medicine);

        return $occurrences[0]->remaining - ($intervalDays * count($occurrencesManagementHours));
    }
}
