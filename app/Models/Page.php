<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    protected $fillable = [
        'title_fr',
        'title_ar',
        'slug',
        'content_fr',
        'content_ar',
        'image_path',
        'meta_title_fr',
        'meta_title_ar',
        'meta_description_fr',
        'meta_description_ar',
        'is_active',
        'show_in_menu',
        'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
        'position' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCmsCache());
        static::deleted(fn () => static::clearCmsCache());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->ordered();
    }

    public function activeSections(): HasMany
    {
        return $this->sections()->active();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('title_fr');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_fr;
    }

    public function getContentAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->content_ar : $this->content_fr;
    }

    public function getMetaTitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->meta_title_ar : $this->meta_title_fr;
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->meta_description_ar : $this->meta_description_fr;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public static function cachedActive(): mixed
    {
        return Cache::rememberForever('cms.pages.active', function () {
            return static::query()->active()->ordered()->get();
        });
    }

    public static function cachedHome(): ?self
    {
        return Cache::rememberForever('cms.pages.home', function () {
            return static::query()
                ->active()
                ->whereIn('slug', ['accueil', 'home'])
                ->with(['sections' => fn ($query) => $query->active()->ordered()])
                ->ordered()
                ->first();
        });
    }

    public static function clearCmsCache(): void
    {
        Cache::forget('cms.pages.active');
        Cache::forget('cms.pages.home');
    }
}
