<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    public const TYPES = ['internal', 'external', 'page', 'route'];
    public const TARGETS = ['_self', '_blank'];

    protected $fillable = [
        'parent_id',
        'title_fr',
        'title_ar',
        'slug',
        'url',
        'type',
        'target',
        'position',
        'is_active',
        'show_in_header',
        'show_in_footer',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'position' => 'integer',
        'is_active' => 'boolean',
        'show_in_header' => 'boolean',
        'show_in_footer' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearMenuCache());
        static::deleted(fn () => static::clearMenuCache());
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->active();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeHeader(Builder $query): Builder
    {
        return $query->where('show_in_header', true);
    }

    public function scopeFooter(Builder $query): Builder
    {
        return $query->where('show_in_footer', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('title_fr');
    }

    public function getLocalizedTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_fr;
    }

    public function getHrefAttribute(): string
    {
        $url = trim((string) $this->url);

        if ($url === '') {
            return '#';
        }

        if ($this->type === 'external') {
            return $url;
        }

        if ($this->type === 'route') {
            return Route::has($url) ? route($url) : url($url);
        }

        if (str_starts_with($url, '#')) {
            return route('home') . $url;
        }

        return url($url);
    }

    public static function cachedTree(string $location): mixed
    {
        $location = $location === 'footer' ? 'footer' : 'header';

        return Cache::rememberForever("menus.{$location}", function () use ($location) {
            $locationScope = $location === 'footer' ? 'footer' : 'header';

            return static::query()
                ->active()
                ->{$locationScope}()
                ->whereNull('parent_id')
                ->with(['children' => function ($query) use ($locationScope) {
                    $query->active()->{$locationScope}()->ordered();
                }])
                ->ordered()
                ->get();
        });
    }

    public static function clearMenuCache(): void
    {
        Cache::forget('menus.header');
        Cache::forget('menus.footer');
    }
}
