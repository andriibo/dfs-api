<?php

namespace App\Mappers;

use App\Dto\FilterSortDto;

class FilterSortMapper
{
    public function map(string $sortField, string $sortOrder): FilterSortDto
    {
        $filterSortDto = new FilterSortDto();
        $filterSortDto->sortField = $sortField;
        $filterSortDto->sortOrder = $sortOrder;

        return $filterSortDto;
    }
}
