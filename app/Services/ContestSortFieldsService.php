<?php

namespace App\Services;

class ContestSortFieldsService extends SortFieldsService
{
    protected function getSortFields(): array
    {
        return [
            'title' => 'title',
            'salaryCap' => 'salary_cap',
            'entries' => 'entries',
            'entryFee' => 'entry_fee',
            'prizeBank' => 'prize_bank',
            'startDate' => 'start_date',
        ];
    }
}
