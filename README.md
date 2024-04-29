# medicine-time

Helps to manage medicine administration.

## Data schema

Check the `migrations` folder. It holds the schema data information.

Following the tables explanation:

* medicines_hour: Holds the medicine management time. Also used to relate medicines to patient. Handled by `M01MedicineHourMigration` class.
* medicines: Holds medicine data. Handled by M01MedicinesMigration `class`.