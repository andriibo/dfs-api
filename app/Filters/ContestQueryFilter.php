<?php

namespace App\Filters;

use App\Exceptions\ContestSortFieldsServiceException;
use App\Services\ContestSortFieldsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContestQueryFilter
{
    private Builder $builder;

    public function __construct(
        private readonly Request $request,
        private readonly ContestSortFieldsService $contestSortFieldsService
    ) {
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $method => $value) {
            if (method_exists($this, $method) && $this->isNotEmptyValue($value, $method)) {
                call_user_func_array([$this, $method], [$value]);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }

    /**
     * @throws ContestSortFieldsServiceException
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

    private function isNotEmptyValue($value, $method): bool
    {
        return !empty($value);
    }
}
