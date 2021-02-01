<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait SearchQueryFilter {

    /**
     * Enhances a query builder with additional conditions for
     * matching the query string with the list of columns.
     * @param Builder $queryBuilder Original \Illuminate\Database\Eloquent\Builder .
     * @param array $cols An array containing the column names. Relationships can be accessed with table.column name.
     * @param $queryString String|null Search keywords separated by space.
     * @return Builder
     */
    private function applyQueryFilter(Builder $queryBuilder, array $cols, ?string $queryString): Builder
    {
        if (!empty($queryString)) {
            $keywords = explode(' ', $queryString);

            $queryBuilder->where(function ($builder) use ($keywords, $cols) {
                foreach ($keywords as $keyword) {
                    if (!empty($keyword)) {
                        foreach ($cols as $col) {
                            if (Str::contains($col, '.')) {
                                $relation = explode('.', $col);
                                $builder->orWhereHas($relation[0], function (Builder $query) use (
                                    $relation,
                                    $keyword
                                ) {
                                    $query->where($relation[1], 'like', '%' . $keyword . '%');
                                });
                            } else {
                                $builder->orWhere($col, 'like', '%' . $keyword . '%');
                            }
                        }
                    }
                }
            });
        }
        return $queryBuilder;
    }
}
