<?php

namespace App\Services;

use App\Dto\FilterSortDto;
use App\Exceptions\SortFieldsServiceException;
use App\Mappers\FilterSortMapper;

abstract class SortFieldsService
{
    private const ORDER_ASC = 'asc';
    private const ORDER_DESC = 'desc';

    private const ORDER_DESC_REQUEST = '-';

    public function __construct(private readonly FilterSortMapper $filterSortMapper = new FilterSortMapper())
    {
    }

    /**
     * @throws SortFieldsServiceException
     */
    public function prepareSortString(string $sortString): FilterSortDto
    {
        $preparedSortString = $sortString;

        if ($sortString[0] === self::ORDER_DESC_REQUEST) {
            $sortOrder = self::ORDER_DESC;
            $preparedSortString = ltrim($preparedSortString, self::ORDER_DESC_REQUEST);
        } else {
            $sortOrder = self::ORDER_ASC;
        }

        if (isset($this->getSortFields()[$preparedSortString])) {
            $sortField = $this->getSortFields()[$preparedSortString];
        }

        if (!isset($sortField) || !isset($sortOrder)) {
            throw new SortFieldsServiceException('Invalid filter sort params.');
        }

        return $this->filterSortMapper->map($sortField, $sortOrder);
    }

    abstract protected function getSortFields(): array;

    private function getSortOrders(): array
    {
        return [self::ORDER_ASC, self::ORDER_DESC];
    }
}
