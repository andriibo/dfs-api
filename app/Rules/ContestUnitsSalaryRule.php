<?php

namespace App\Rules;

use App\Models\Contests\Contest;
use Illuminate\Contracts\Validation\Rule;

class ContestUnitsSalaryRule implements Rule
{
    public function __construct(private readonly Contest $contest)
    {
    }

    public function passes($attribute, $value): bool
    {
        if (!$this->contest->isGameTypeSalary()) {
            return true;
        }
        $salaries = $this->contest->contestUnits->pluck('salary', 'id')->toArray();
        $budget = 0;
        foreach ($value as $unit) {
            $unitId = $unit['id'];
            $budget += $salaries[$unitId];
        }

        return $budget <= $this->contest->salary_cap;
    }

    public function message(): string
    {
        return "Salary cap {$this->contest->salary_cap} exceeded";
    }
}
