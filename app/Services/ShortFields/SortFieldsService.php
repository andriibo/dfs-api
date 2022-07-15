<?php

namespace App\Services\ShortFields;

use App\Dto\FilterSortDto;
use App\Mappers\FilterSortMapper;
use Exception;

abstract class SortFieldsService
{
    private const ORDER_ASC = 'asc';
    private const ORDER_DESC = 'desc';

    public function __construct(private readonly FilterSortMapper $filterSortMapper = new FilterSortMapper())
    {
    }

    /**
     * @throws Exception
     */
    public function prepareSortString(string $sortString): FilterSortDto
    {
        $preparedSortString = explode('-', $sortString);

        if (isset($preparedSortString[0], $this->getSortFields()[$preparedSortString[0]])) {
            $sortField = $this->getSortFields()[$preparedSortString[0]];
        }

        if (isset($preparedSortString[1]) && in_array($preparedSortString[1], $this->getSortOrders())) {
            $sortOrder = $preparedSortString[1];
        }

        if (!isset($sortField) || !isset($sortOrder)) {
            throw new Exception('Invalid filter sort params.');
        }

        return $this->filterSortMapper->map($sortField, $sortOrder);
    }

    abstract protected function getSortFields(): array;

    private function getSortOrders(): array
    {
        return [self::ORDER_ASC, self::ORDER_DESC];
    }
}
