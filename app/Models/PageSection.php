<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PageSection extends Model
{
    public const TYPES = [
        'hero',
        'text_image',
        'stats',
        'cards',
        'news',
        'documents',
        'gallery',
        'cta',
        'contact',
        'custom',
    ];

    protected $fillable = [
        'page_id',
        'section_key',
        'section_type',
        'title_fr',
        'title_ar',
        'subtitle_fr',
        'subtitle_ar',
        'content_fr',
        'content_ar',
        'image_path',
        'video_url',
        'button_text_fr',
        'button_text_ar',
        'button_url',
        'second_button_text_fr',
        'second_button_text_ar',
        'second_button_url',
        'extra_data',
        'position',
        'is_active',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Page::clearCmsCache());
        static::deleted(fn () => Page::clearCmsCache());
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position')->orderBy('section_key');
    }

    public function getTitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_fr;
    }

    public function getSubtitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->subtitle_ar : $this->subtitle_fr;
    }

    public function getContentAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->content_ar : $this->content_fr;
    }

    public function getButtonTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->button_text_ar : $this->button_text_fr;
    }

    public function getSecondButtonTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->second_button_text_ar : $this->second_button_text_fr;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }
}
