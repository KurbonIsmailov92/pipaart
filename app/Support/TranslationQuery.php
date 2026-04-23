<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

class TranslationQuery
{
    public static function expression(Builder $query, string $column, ?string $locale = null, ?string $fallbackLocale = null): string
    {
        $locale ??= app()->getLocale();
        $fallbackLocale ??= config('app.fallback_locale', 'ru');
        $driver = $query->getConnection()->getDriverName();
        $wrappedColumn = $query->getGrammar()->wrap($column);

        return match ($driver) {
            'pgsql' => "coalesce({$wrappedColumn}->>'{$locale}', {$wrappedColumn}->>'{$fallbackLocale}')",
            'sqlite' => "coalesce(json_extract({$wrappedColumn}, '$.\"{$locale}\"'), json_extract({$wrappedColumn}, '$.\"{$fallbackLocale}\"'))",
            default => "coalesce(json_unquote(json_extract({$wrappedColumn}, '$.\"{$locale}\"')), json_unquote(json_extract({$wrappedColumn}, '$.\"{$fallbackLocale}\"')))",
        };
    }

    public static function orderByTranslated(Builder $query, string $column, string $direction = 'asc'): Builder
    {
        return $query->orderByRaw(self::expression($query, $column).' '.$direction);
    }

    /**
     * @param  list<string>  $columns
     */
    public static function whereAnyTranslatedLike(Builder $query, array $columns, string $search): Builder
    {
        return $query->where(function (Builder $builder) use ($columns, $search): void {
            foreach ($columns as $column) {
                $builder->orWhereRaw(
                    self::expression($builder, $column).' like ?',
                    ['%'.$search.'%'],
                );
            }
        });
    }
}
