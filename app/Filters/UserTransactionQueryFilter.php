<?php

namespace App\Filters;

use App\Exceptions\SortFieldsServiceException;
use App\Services\UserTransactionSortFieldsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class UserTransactionQueryFilter extends QueryFilter
{
    public function __construct(
        Request $request,
        private readonly UserTransactionSortFieldsService $userTransactionSortFieldsService
    ) {
        parent::__construct($request);
    }

    /**
     * @throws SortFieldsServiceException
     */
    public function sort(string $sort): Builder
    {
        $filterSortDto = $this->userTransactionSortFieldsService->prepareSortString($sort);

        return $this->builder->orderBy($filterSortDto->sortField, $filterSortDto->sortOrder);
    }
}
