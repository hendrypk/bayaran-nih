<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'eid' => $this->faker->unique()->numberBetween(1000, 9999),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'),
            'name' => $this->faker->name(),
            'city' => $this->faker->city(),
            'domicile' => $this->faker->address(),
            'place_birth' => $this->faker->city(),
            'date_birth' => $this->faker->date('Y-m-d', '-20 years'),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'religion' => $this->faker->randomElement(['islam', 'christian', 'catholic', 'hindu', 'buddha', 'konghuchu']),
            'marriage' => $this->faker->randomElement(['single', 'married', 'widowed']),
            'education' => $this->faker->randomElement(['high_school', 'diploma', 'bachelor', 'master']),
            'whatsapp' => $this->faker->phoneNumber(),
            'bank' => $this->faker->randomElement(['Bank BCA', 'Bank Mandiri', 'Bank BNI']),
            'bank_number' => $this->faker->bankAccountNumber(),
            
            // Relasi (Asumsi ID 1-5 sudah ada)
            'position_id' => $this->faker->numberBetween(1, 5),
            'division_id' => $this->faker->numberBetween(1, 3),
            'department_id' => $this->faker->numberBetween(1, 3),
            
            'joining_date' => $this->faker->date('Y-m-d', '-2 years'),
            'employee_status' => $this->faker->randomElement([1, 2]), // Sesuai ID di table employee_statuses
            'role' => 'staff',
            'annual_leave' => 12,
            'due_annual_leave' => $this->faker->date('Y-m-d', '1 years')
        ];
    }
}