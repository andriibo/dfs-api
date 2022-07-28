<?php

namespace App\Services;

class UserTransactionSortFieldsService extends SortFieldsService
{
    protected function getSortFields(): array
    {
        return [
            'type' => 'type',
            'status' => 'status',
            'amount' => 'amount',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];
    }
}
