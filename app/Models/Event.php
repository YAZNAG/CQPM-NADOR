<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'title_fr',
        'title_ar',
        'slug',
        'excerpt_fr',
        'excerpt_ar',
        'content_fr',
        'content_ar',
        'location_fr',
        'location_ar',
        'image_path',
        'meta_title_fr',
        'meta_title_ar',
        'meta_description_fr',
        'meta_description_ar',
        'starts_at',
        'ends_at',
        'is_active',
        'position',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearEventCache());
        static::deleted(fn () => static::clearEventCache());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderByDesc('starts_at')->orderByDesc('created_at');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_fr;
    }

    public function getExcerptAttribute(): ?string
    {
        $localized = app()->getLocale() === 'ar' ? $this->excerpt_ar : $this->excerpt_fr;

        return $localized ?: str($this->content)->stripTags()->limit(180)->toString();
    }

    public function getContentAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->content_ar : $this->content_fr;
    }

    public function getLocationAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->location_ar : $this->location_fr;
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

    public static function cachedUpcoming(int $limit = 6): mixed
    {
        return Cache::rememberForever("events.upcoming.{$limit}", function () use ($limit) {
            return static::query()->active()->ordered()->take($limit)->get();
        });
    }

    public static function clearEventCache(): void
    {
        Cache::forget('events.upcoming.3');
        Cache::forget('events.upcoming.6');
        Cache::forget('events.upcoming.9');
    }
}
