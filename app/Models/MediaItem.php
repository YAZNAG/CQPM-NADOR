<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MediaItem extends Model
{
    public const TYPES = ['image', 'video'];

    protected $fillable = [
        'title_fr',
        'title_ar',
        'slug',
        'description_fr',
        'description_ar',
        'media_type',
        'image_path',
        'video_url',
        'alt_fr',
        'alt_ar',
        'category_fr',
        'category_ar',
        'meta_title_fr',
        'meta_title_ar',
        'meta_description_fr',
        'meta_description_ar',
        'is_active',
        'position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearMediaCache());
        static::deleted(fn () => static::clearMediaCache());
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
        return $query->orderBy('position')->orderByDesc('created_at');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_fr;
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_fr;
    }

    public function getAltAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->alt_ar ?: $this->title_ar) : ($this->alt_fr ?: $this->title_fr);
    }

    public function getCategoryAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->category_ar : $this->category_fr;
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

    public static function cachedGallery(int $limit = 12): mixed
    {
        return Cache::rememberForever("media.gallery.{$limit}", function () use ($limit) {
            return static::query()->active()->ordered()->take($limit)->get();
        });
    }

    public static function clearMediaCache(): void
    {
        Cache::forget('media.gallery.6');
        Cache::forget('media.gallery.9');
        Cache::forget('media.gallery.12');
    }
}
