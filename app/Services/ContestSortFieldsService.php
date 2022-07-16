<?php

namespace App\Services;

use App\Dto\FilterSortDto;
use App\Exceptions\ContestSortFieldsServiceException;
use App\Mappers\FilterSortMapper;

class ContestSortFieldsService
{
    private const ORDER_ASC = 'asc';
    private const ORDER_DESC = 'desc';

    private const ORDER_DESC_REQUEST = '-';

    public function __construct(private readonly FilterSortMapper $filterSortMapper = new FilterSortMapper())
    {
    }

    /**
     * @throws ContestSortFieldsServiceException
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
            throw new ContestSortFieldsServiceException('Invalid filter sort params.');
        }

        return $this->filterSortMapper->map($sortField, $sortOrder);
    }

    private function getSortFields(): array
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
