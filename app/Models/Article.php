<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
        'title_fr',
        'title_ar',
        'slug',
        'excerpt_fr',
        'excerpt_ar',
        'content_fr',
        'content_ar',
        'image_path',
        'meta_title_fr',
        'meta_title_ar',
        'meta_description_fr',
        'meta_description_ar',
        'published_at',
        'is_active',
        'position',
        'title',
        'content',
        'file_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'position' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearNewsCache());
        static::deleted(fn () => static::clearNewsCache());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function ($subQuery) {
            $subQuery->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderByDesc('published_at')->orderByDesc('created_at');
    }

    public function getTitleAttribute(): string
    {
        $localized = app()->getLocale() === 'ar'
            ? ($this->attributes['title_ar'] ?? null)
            : ($this->attributes['title_fr'] ?? null);

        return $localized ?: ($this->attributes['title'] ?? '');
    }

    public function getExcerptAttribute(): ?string
    {
        $localized = app()->getLocale() === 'ar'
            ? ($this->attributes['excerpt_ar'] ?? null)
            : ($this->attributes['excerpt_fr'] ?? null);

        return $localized ?: str($this->content)->stripTags()->limit(180)->toString();
    }

    public function getContentAttribute(): ?string
    {
        $localized = app()->getLocale() === 'ar'
            ? ($this->attributes['content_ar'] ?? null)
            : ($this->attributes['content_fr'] ?? null);

        return $localized ?: ($this->attributes['content'] ?? null);
    }

    public function getMetaTitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->attributes['meta_title_ar'] ?? null)
            : ($this->attributes['meta_title_fr'] ?? null);
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->attributes['meta_description_ar'] ?? null)
            : ($this->attributes['meta_description_fr'] ?? null);
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }

        return $this->isImage() ? $this->file_url : null;
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function isImage(): bool
    {
        if (! $this->file_path) {
            return false;
        }
        $ext = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function isPdf(): bool
    {
        if (! $this->file_path) {
            return false;
        }
        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION)) === 'pdf';
    }

    public static function cachedRecent(int $limit = 6): mixed
    {
        return Cache::rememberForever("news.recent.{$limit}", function () use ($limit) {
            return static::query()->active()->published()->ordered()->take($limit)->get();
        });
    }

    public static function clearNewsCache(): void
    {
        Cache::forget('news.recent.3');
        Cache::forget('news.recent.6');
        Cache::forget('news.recent.9');
    }
}
