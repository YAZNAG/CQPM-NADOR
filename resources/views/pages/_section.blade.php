@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
    $sectionSettings = $settings ?? \App\Models\SiteSetting::all_settings();
    $siteSigle = $sectionSettings['sigle'] ?? 'CQPM Nador';
    $siteNameAr = $sectionSettings['nom_ar'] ?? 'مركز الناظور';
    $anchorMap = [
        'presentation_centre' => 'l-institut',
        'documents' => 'avis',
        'appel_action' => 'appel-action',
    ];
    $anchor = $anchorMap[$section->section_key] ?? $section->section_key;
    $extraData = is_array($section->extra_data) ? $section->extra_data : [];
    $resolveUrl = function (?string $url) {
        if (! $url) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        if (\Illuminate\Support\Str::startsWith($url, '#')) {
            return request()->path() === '/' ? $url : route('home') . $url;
        }

        return url($url);
    };
    $buttonUrl = $resolveUrl($section->button_url);
    $secondButtonUrl = $resolveUrl($section->second_button_url);
@endphp

@switch($section->section_type)
    @case('hero')
        <section id="{{ $anchor }}" class="relative overflow-hidden bg-navy text-white">
            @if($section->image_url)
                <img src="{{ $section->image_url }}" alt="{{ $section->title }}" class="absolute inset-0 w-full h-full object-cover opacity-35">
            @endif
            <div class="absolute inset-0 bg-navy/80"></div>
            <div class="relative max-w-screen-xl mx-auto px-4 py-20 md:py-28 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-8 cms-animate">
                    @if($section->subtitle)
                        <div class="inline-flex items-center gap-2 bg-gold/15 border border-gold/30 rounded-full px-4 py-1.5 mb-6">
                            <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                            <span class="text-gold text-xs font-semibold uppercase tracking-widest">{{ $section->subtitle }}</span>
                        </div>
                    @endif
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-5 max-w-4xl">{{ $section->title }}</h1>
                    @if($section->content)
                        <p class="text-white/75 text-base md:text-lg leading-relaxed max-w-2xl whitespace-pre-line">{{ $section->content }}</p>
                    @endif
                    <div class="flex flex-wrap gap-3 mt-8">
                        @if($section->button_text && $buttonUrl)
                            <a href="{{ $buttonUrl }}" class="inline-flex items-center justify-center px-7 py-3.5 bg-gold hover:bg-gold-dark text-navy font-bold rounded text-sm transition-all shadow-lg">
                                {{ $section->button_text }}
                            </a>
                        @endif
                        @if($section->second_button_text && $secondButtonUrl)
                            <a href="{{ $secondButtonUrl }}" class="inline-flex items-center justify-center px-7 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold border border-white/20 rounded text-sm transition-all">
                                {{ $section->second_button_text }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-4 cms-animate">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-5 grid grid-cols-2 gap-4">
                        @foreach($extraData ?: [
                            ['label_fr' => 'Diplômés', 'label_ar' => 'الخريجون', 'value' => '1500+'],
                            ['label_fr' => 'Filières', 'label_ar' => 'التكوينات', 'value' => '8'],
                            ['label_fr' => 'Insertion', 'label_ar' => 'الإدماج', 'value' => '85%'],
                            ['label_fr' => 'Expérience', 'label_ar' => 'الخبرة', 'value' => '15+'],
                        ] as $stat)
                            <div class="text-center">
                                <div class="text-2xl font-extrabold text-gold">{{ $stat['value'] ?? '' }}</div>
                                <div class="text-white/65 text-xs mt-0.5 leading-tight">{{ $stat[$locale === 'ar' ? 'label_ar' : 'label_fr'] ?? '' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @break

    @case('stats')
        <section id="{{ $anchor }}" class="py-14 bg-white border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="text-center mb-10 cms-animate">
                    @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy">{{ $section->title }}</h2>@endif
                    @if($section->subtitle)<p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">{{ $section->subtitle }}</p>@endif
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($extraData as $stat)
                        <div class="cms-animate bg-sea-light border border-sea/10 rounded-xl p-5 text-center hover:-translate-y-1 hover:shadow-md transition-all">
                            <div class="text-3xl font-extrabold text-navy" data-counter="{{ $stat['value'] ?? '0' }}">0</div>
                            <div class="text-sm text-gray-600 mt-1">{{ $stat[$locale === 'ar' ? 'label_ar' : 'label_fr'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @break

    @case('text_image')
    @case('custom')
        <section id="{{ $anchor }}" class="py-14 {{ $loop->even ?? false ? 'bg-gray-50' : 'bg-white' }} border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">
                    <div class="lg:col-span-3 cms-animate {{ $isRtl ? 'lg:order-2' : '' }}">
                        @if($section->subtitle)
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1 h-8 bg-gold rounded-full"></div>
                                <span class="text-gold font-bold text-xs uppercase tracking-widest">{{ $section->subtitle }}</span>
                            </div>
                        @endif
                        @if($section->title)
                            <h2 class="text-2xl md:text-3xl font-bold text-navy mb-5 leading-snug">{{ $section->title }}</h2>
                        @endif
                        @if($section->content)
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed whitespace-pre-line">{{ $section->content }}</p>
                        @endif
                        @if($section->button_text && $buttonUrl)
                            <a href="{{ $buttonUrl }}" class="mt-6 inline-flex items-center justify-center px-6 py-3 bg-navy hover:bg-navy-light text-white text-sm font-bold rounded transition-all">
                                {{ $section->button_text }}
                            </a>
                        @endif
                    </div>
                    <div class="lg:col-span-2 cms-animate {{ $isRtl ? 'lg:order-1' : '' }}">
                        @if($section->image_url)
                            <img src="{{ $section->image_url }}" alt="{{ $section->title }}" class="w-full aspect-[4/3] object-cover rounded-xl shadow-lg">
                        @else
                            <div class="w-full aspect-[4/3] rounded-xl bg-navy border border-navy/10 shadow-lg flex items-center justify-center">
                                <div class="text-center px-6">
                                    <div class="w-14 h-14 bg-gold rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-navy" fill="currentColor" viewBox="0 0 24 24"><path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2z"/></svg>
                                    </div>
                                    <p class="text-white/70 text-sm">{{ $section->title }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @break

    @case('cards')
        <section id="{{ $anchor }}" class="py-14 bg-white border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="text-center mb-10 cms-animate">
                    @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy">{{ $section->title }}</h2>@endif
                    @if($section->subtitle)<p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">{{ $section->subtitle }}</p>@endif
                </div>

                @if(($filieres ?? collect())->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($filieres as $filiere)
                            <div class="cms-animate bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg hover:border-navy/20 transition-all group">
                                <div class="h-1.5 bg-navy group-hover:bg-gold transition-colors"></div>
                                <div class="p-5 flex flex-col h-full">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-11 h-11 bg-sea-light rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                            @if($filiere->icon_path)
                                                <img src="{{ $filiere->icon_url }}" alt="{{ $filiere->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-sea" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-bold text-navy text-sm group-hover:text-sea transition-colors leading-tight mb-1">{{ $filiere->title }}</h3>
                                            <span class="inline-block text-xs bg-navy/10 text-navy px-2 py-0.5 rounded font-medium">{{ $filiere->badge }}</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-xs leading-relaxed flex-1 mb-4">{{ $filiere->description }}</p>
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <span class="text-xs text-gray-400">{{ $filiere->duration }}</span>
                                        <a href="{{ route('candidature.form') }}" class="text-xs font-bold text-gold hover:text-gold-dark transition-colors">{{ $isRtl ? 'الترشح' : 'Postuler' }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach($extraData as $card)
                            <div class="cms-animate bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all">
                                <h3 class="font-bold text-navy mb-2">{{ $card[$locale === 'ar' ? 'title_ar' : 'title_fr'] ?? '' }}</h3>
                                <p class="text-sm text-gray-500">{{ $card[$locale === 'ar' ? 'content_ar' : 'content_fr'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($section->button_text && $buttonUrl)
                    <div class="text-center mt-8">
                        <a href="{{ $buttonUrl }}" class="inline-flex items-center justify-center px-8 py-3 bg-navy hover:bg-navy-light text-white font-bold rounded text-sm transition-all shadow-md">
                            {{ $section->button_text }}
                        </a>
                    </div>
                @endif
            </div>
        </section>
        @break

    @case('news')
        <section id="{{ $anchor }}" class="py-14 bg-gray-50 border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="text-center mb-10 cms-animate">
                    @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy">{{ $section->title }}</h2>@endif
                    @if($section->subtitle)<p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">{{ $section->subtitle }}</p>@endif
                </div>
                @if(($articles ?? collect())->isEmpty())
                    <div class="max-w-lg mx-auto text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-200 text-gray-400 text-sm">{{ $isRtl ? 'لا توجد أخبار منشورة حاليا.' : 'Aucune actualité publiée pour le moment.' }}</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($articles as $article)
                            <article class="cms-animate group bg-white border border-gray-200 hover:border-navy/20 rounded-xl overflow-hidden hover:shadow-lg transition-all flex flex-col">
                                @if($article->file_path && $article->isImage())
                                    <div class="w-full h-40 overflow-hidden bg-gray-100">
                                        <img src="{{ $article->file_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @endif
                                <div class="p-5 flex flex-col flex-1">
                                    <time class="text-xs font-semibold text-gold mb-3">{{ $article->created_at->format('d/m/Y') }}</time>
                                    <h3 class="font-bold text-navy text-sm leading-snug mb-2 group-hover:text-sea transition-colors">{{ $article->title }}</h3>
                                    <p class="text-gray-500 text-xs leading-relaxed flex-1 mb-4">{{ Str::limit($article->content, 130) }}</p>
                                    <a href="{{ route('news.show', $article) }}" class="text-xs font-bold text-gold hover:text-gold-dark transition-colors">{{ $isRtl ? 'اقرأ المزيد' : 'Lire la suite' }}</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        @break

    @case('documents')
        <section id="{{ $anchor }}" class="py-14 bg-white border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="text-center mb-10 cms-animate">
                    @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy">{{ $section->title }}</h2>@endif
                    @if($section->subtitle)<p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">{{ $section->subtitle }}</p>@endif
                </div>
                @if(($documents ?? collect())->isEmpty())
                    <div class="max-w-lg mx-auto text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 text-gray-400 text-sm">{{ $isRtl ? 'لا توجد وثائق منشورة حاليا.' : 'Aucun document publié pour le moment.' }}</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($documents as $doc)
                            <div class="cms-animate group flex flex-col bg-white border border-gray-200 hover:border-navy/30 rounded-xl overflow-hidden hover:shadow-md transition-all">
                                <div class="bg-red-600 px-4 py-3 text-white text-xs font-bold tracking-wide uppercase">PDF</div>
                                <div class="flex-1 p-4 flex flex-col">
                                    <h3 class="font-semibold text-navy text-sm leading-snug mb-2 group-hover:text-sea transition-colors">{{ $doc->title }}</h3>
                                    <p class="text-gray-400 text-xs mb-4 flex-1">{{ $isRtl ? 'نشر بتاريخ' : 'Publié le' }} {{ $doc->created_at->format('d/m/Y') }}</p>
                                    <a href="{{ $doc->public_url }}" target="_blank" download class="text-center w-full py-2 bg-navy hover:bg-gold hover:text-navy text-white text-xs font-bold rounded transition-all">
                                        {{ $isRtl ? 'تحميل' : 'Télécharger' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        @break

    @case('gallery')
        <section id="{{ $anchor }}" class="py-14 bg-gray-50 border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4">
                <div class="text-center mb-10 cms-animate">
                    @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy">{{ $section->title }}</h2>@endif
                    @if($section->subtitle)<p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">{{ $section->subtitle }}</p>@endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @if(($mediaItems ?? collect())->isNotEmpty())
                        @foreach($mediaItems as $mediaItem)
                            <a href="{{ route('media.show', $mediaItem) }}" class="cms-animate rounded-xl overflow-hidden border border-gray-200 bg-white shadow-sm group">
                                <div class="aspect-[4/3] bg-navy flex items-center justify-center overflow-hidden">
                                    @if($mediaItem->image_url)
                                        <img src="{{ $mediaItem->image_url }}" alt="{{ $mediaItem->alt }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <span class="text-gold font-bold text-lg">{{ $mediaItem->title }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @else
                    @foreach($extraData ?: [['title_fr' => $siteSigle, 'title_ar' => $siteNameAr]] as $item)
                        <div class="cms-animate rounded-xl overflow-hidden border border-gray-200 bg-white shadow-sm group">
                            <div class="aspect-[4/3] bg-navy flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-300">
                                <span class="text-gold font-bold text-lg">{{ $item[$locale === 'ar' ? 'title_ar' : 'title_fr'] ?? $siteSigle }}</span>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </section>
        @break

    @case('cta')
        <section id="{{ $anchor }}" class="bg-navy py-12">
            <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-center {{ $isRtl ? 'md:text-right' : 'md:text-left' }} cms-animate">
                <div>
                    @if($section->title)<h3 class="text-xl md:text-2xl font-bold text-white mb-2">{{ $section->title }}</h3>@endif
                    @if($section->content)<p class="text-white/65 text-sm max-w-2xl">{{ $section->content }}</p>@endif
                </div>
                <div class="flex flex-wrap gap-3 justify-center md:justify-end">
                    @if($section->button_text && $buttonUrl)
                        <a href="{{ $buttonUrl }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-gold hover:bg-gold-dark text-navy font-bold rounded text-sm transition-all shadow-lg whitespace-nowrap">{{ $section->button_text }}</a>
                    @endif
                    @if($section->second_button_text && $secondButtonUrl)
                        <a href="{{ $secondButtonUrl }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold border border-white/25 rounded text-sm transition-all whitespace-nowrap">{{ $section->second_button_text }}</a>
                    @endif
                </div>
            </div>
        </section>
        @break

    @default
        <section id="{{ $anchor }}" class="py-14 bg-white border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4 cms-animate">
                @if($section->title)<h2 class="text-2xl md:text-3xl font-bold text-navy mb-4">{{ $section->title }}</h2>@endif
                @if($section->content)<p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $section->content }}</p>@endif
            </div>
        </section>
@endswitch
