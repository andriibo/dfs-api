<?php

namespace App\Services;

class UserTransactionSortFieldsService extends SortFieldsService
{
    protected function getSortFields(): array
    {
        return [
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];
    }
}
