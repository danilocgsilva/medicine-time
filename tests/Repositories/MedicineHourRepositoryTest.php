<?php

declare(strict_types= 1);

namespace Danilocgsilva\MedicineTime\Tests\Repositories;

use Danilocgsilva\MedicineTime\Repositories\MedicinesRepository;
use Danilocgsilva\MedicineTime\Repositories\PatientRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\PatientTrait;
use Danilocgsilva\MedicineTime\Tests\Commons\TestCaseDB;
use Danilocgsilva\MedicineTime\Repositories\MedicineHourRepository;
use Danilocgsilva\MedicineTime\Tests\Commons\MedicineTrait;
use Danilocgsilva\MedicineTime\Migrations\M01MedicineHourMigration;
use Danilocgsilva\MedicineTime\Migrations\M01MedicinesMigration;

class MedicineHourRepositoryTest extends TestCaseDB
{
    use MedicineTrait, PatientTrait;
    
    private MedicineHourRepository $medicineHourRepository;
    
    private MedicinesRepository $medicinesRepository;

    private PatientRepository $patientRepository;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->medicineHourRepository = new MedicineHourRepository($this->pdo);
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
        $this->medicinesRepository = new MedicinesRepository($this->pdo);
        $this->patientRepository = new PatientRepository($this->pdo);
    }
    
    public function testSaveAndGet(): void
    {
        $this->renewByMigration(new M01MedicinesMigration());
        $this->renewByMigration(new M01MedicineHourMigration());
        
        $medicine = $this->createTestingMedicine("Alopurinol 40mg");
        $this->medicinesRepository->save($medicine);

        $patient = $this->createTestingPatient("John Doe");
        $this->patientRepository->save($patient);
        
        $this->medicineHourRepository->addManagementHour(11, $medicine, $patient);
        
        $this->assertSame(
            "11:00:00",
            $this->medicineHourRepository->getMenagementHours($medicine)[0]->hour
        );
    }
}
