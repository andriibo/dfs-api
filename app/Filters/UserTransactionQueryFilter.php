<?php

namespace App\Filters;

use App\Services\ShortFields\UserTransactionSortFieldsService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class UserTransactionQueryFilter extends QueryFilter
{
    public function __construct(
        Request $request,
        private readonly UserTransactionSortFieldsService $userTransactionSortFieldsService = new UserTransactionSortFieldsService()
    ) {
        parent::__construct($request);
    }

    /**
     * @throws Exception
     */
    public function sort(string $sort): Builder
    {
        $filterSortDto = $this->userTransactionSortFieldsService->prepareSortString($sort);

        return $this->builder->orderBy($filterSortDto->sortField, $filterSortDto->sortOrder);
    }
}
