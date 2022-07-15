<?php

namespace App\Filters;

use App\Services\ShortFields\ContestSortFieldsService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class ContestQueryFilter extends QueryFilter
{
    public function __construct(
        Request $request,
        private readonly ContestSortFieldsService $contestSortFieldsService = new ContestSortFieldsService()
    ) {
        parent::__construct($request);
    }

    /**
     * @throws Exception
     */
    public function sort(string $sort): Builder
    {
        $filterSortDto = $this->contestSortFieldsService->prepareSortString($sort);
        $sortField = $filterSortDto->sortField;

        if ($filterSortDto->sortField === 'entries') {
            $this->builder->withCount('contestUsers');
            $sortField = 'contest_users_count';
        }

        return $this->builder->orderBy($sortField, $filterSortDto->sortOrder);
    }
}
