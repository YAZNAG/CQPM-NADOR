@php
    $currentLocale = app()->getLocale();
    $isRtl = $currentLocale === 'ar';
    $menusReady = \Illuminate\Support\Facades\Schema::hasTable('menus');
    $headerMenus = $menusReady ? \App\Models\Menu::cachedTree('header') : collect();
    $footerMenus = $menusReady ? \App\Models\Menu::cachedTree('footer') : collect();
    $layoutSettings = $settings ?? \App\Models\SiteSetting::all_settings();
    $seo = $seo ?? [];
    $seoPage = $page ?? null;

    $siteSigle = $layoutSettings['sigle'] ?? 'CQPM Nador';
    $siteName = $isRtl ? ($layoutSettings['nom_ar'] ?? $siteSigle) : ($layoutSettings['nom_fr'] ?? $siteSigle);
    $siteNameOther = $isRtl ? ($layoutSettings['nom_fr'] ?? '') : ($layoutSettings['nom_ar'] ?? '');
    $siteSlogan = $isRtl ? ($layoutSettings['slogan_ar'] ?? '') : ($layoutSettings['slogan_fr'] ?? '');
    $siteAddress = $isRtl ? ($layoutSettings['adresse_ar'] ?? '') : ($layoutSettings['adresse_fr'] ?? '');
    $siteHours = $isRtl ? ($layoutSettings['horaires_ar'] ?? '') : ($layoutSettings['horaires_fr'] ?? '');
    $footerDescription = $isRtl ? ($layoutSettings['footer_description_ar'] ?? '') : ($layoutSettings['footer_description_fr'] ?? '');
    $copyrightText = $isRtl ? ($layoutSettings['copyright_ar'] ?? 'جميع الحقوق محفوظة') : ($layoutSettings['copyright_fr'] ?? 'Tous droits réservés');
    $logoUrl = ! empty($layoutSettings['logo'] ?? null) ? \Illuminate\Support\Facades\Storage::url($layoutSettings['logo']) : null;
    $faviconUrl = ! empty($layoutSettings['favicon'] ?? null) ? \Illuminate\Support\Facades\Storage::url($layoutSettings['favicon']) : null;
    $defaultOgImage = ! empty($layoutSettings['default_og_image'] ?? null) ? \Illuminate\Support\Facades\Storage::url($layoutSettings['default_og_image']) : null;
    $showLangSwitcher = ($layoutSettings['afficher_lang_switcher'] ?? '1') === '1';
    $showApplyButton = ($layoutSettings['afficher_bouton_candidature'] ?? '1') === '1';
    $showSocial = ($layoutSettings['afficher_reseaux_sociaux'] ?? '1') === '1';
    $socialLinks = array_filter([
        'Facebook' => $layoutSettings['facebook_url'] ?? null,
        'Instagram' => $layoutSettings['instagram_url'] ?? null,
        'YouTube' => $layoutSettings['youtube_url'] ?? null,
        'LinkedIn' => $layoutSettings['linkedin_url'] ?? null,
    ]);

    $metaTitle = $seo['title'] ?? ($seoPage?->meta_title ?: ($layoutSettings['default_meta_title_' . $currentLocale] ?? ($seoPage?->title ?: $siteName)));
    $metaDescription = $seo['description'] ?? ($seoPage?->meta_description ?: ($layoutSettings['default_meta_description_' . $currentLocale] ?? $siteName));
    $ogImage = $seo['image'] ?? $seoPage?->image_url ?? $defaultOgImage;
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:title" content="@yield('title', $metaTitle)">
    <meta property="og:description" content="{{ $metaDescription }}">
    @if($ogImage)
    <meta property="og:image" content="{{ asset($ogImage) }}">
    @endif
    @if($faviconUrl)
    <link rel="icon" href="{{ $faviconUrl }}">
    @endif
    <title>@yield('title', $metaTitle)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Arabic:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen"
      style="font-family: {{ $isRtl ? "'Noto Sans Arabic', 'Inter', sans-serif" : "'Inter', sans-serif" }};">

@if(($layoutSettings['maintenance_mode'] ?? '0') === '1')
<div class="bg-gold text-navy text-sm font-semibold px-4 py-2 text-center">
    {{ $isRtl ? 'الموقع في وضع الصيانة. قد تكون بعض المعلومات غير محدثة مؤقتا.' : 'Mode maintenance actif. Certaines informations peuvent être temporairement indisponibles.' }}
</div>
@endif

<div class="bg-navy-dark text-white/70 text-sm hidden md:block">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-6">
            @if(!empty($layoutSettings['telephone']))
            <a href="tel:{{ preg_replace('/\s+/', '', $layoutSettings['telephone']) }}" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                {{ $layoutSettings['telephone'] }}
            </a>
            @endif
            @if(!empty($layoutSettings['email']))
            <a href="mailto:{{ $layoutSettings['email'] }}" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                {{ $layoutSettings['email'] }}
            </a>
            @endif
            @if($showSocial && $socialLinks)
            <div class="flex items-center gap-3">
                @foreach($socialLinks as $label => $url)
                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ $label }}</a>
                @endforeach
            </div>
            @endif
        </div>

        @if($showLangSwitcher)
        <div class="flex items-center gap-2 text-xs font-bold">
            <a href="{{ route('lang.switch', 'fr') }}" class="{{ $currentLocale === 'fr' ? 'text-gold' : 'hover:text-white' }}">FR</a>
            <span class="text-white/25">|</span>
            <a href="{{ route('lang.switch', 'ar') }}" class="{{ $currentLocale === 'ar' ? 'text-gold' : 'hover:text-white' }}">العربية</a>
        </div>
        @endif
    </div>
</div>

<header class="bg-white border-b border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-5 md:py-7 flex items-center justify-between gap-6">
        <div class="flex items-center gap-4 shrink-0">
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-2 border-navy/20 flex items-center justify-center bg-white shadow-md">
                <svg viewBox="0 0 80 80" class="w-13 h-13 md:w-16 md:h-16" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="38" fill="none" stroke="#0B3C5D" stroke-width="2"/>
                    <polygon points="40,8 46,30 68,30 51,44 57,66 40,52 23,66 29,44 12,30 34,30" fill="#C4992A" stroke="#A07820" stroke-width="1"/>
                    <circle cx="40" cy="40" r="8" fill="#0B3C5D"/>
                </svg>
            </div>
            <div class="hidden sm:block">
                <div class="text-xs font-bold text-navy uppercase leading-snug tracking-wide">{{ $isRtl ? 'المملكة المغربية' : 'Royaume du Maroc' }}</div>
                <div class="text-xs text-gray-500 leading-snug mt-1">{{ $isRtl ? 'قطاع الصيد البحري' : 'Département de la Pêche Maritime' }}</div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="flex items-center gap-4 shrink-0 group {{ $isRtl ? 'text-left' : 'text-right' }}">
            <div class="hidden lg:block">
                <div class="font-extrabold text-navy text-2xl leading-tight tracking-tight">{{ $siteSigle }}</div>
                <div class="text-sm text-gray-500 mt-0.5">{{ $siteName }}</div>
                @if($siteNameOther)
                <div class="text-sm text-gray-400 mt-0.5">{{ $siteNameOther }}</div>
                @endif
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 bg-navy rounded-full flex items-center justify-center shadow-lg group-hover:bg-navy-light transition-colors shrink-0">
                @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $siteSigle }}" class="w-full h-full object-contain rounded-full bg-white p-1">
                @else
                <svg class="w-8 h-8 md:w-10 md:h-10 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l1.89-6.68c.08-.26.06-.54-.06-.78s-.32-.42-.58-.5L20 10.62V6c0-1.1-.9-2-2-2h-3V1H9v3H6c-1.1 0-2 .9-2 2v4.62l-1.3.42c-.26.08-.46.26-.58.5s-.14.52-.06.78L3.95 19zM6 6h12v3.97L12 8 6 9.97V6z"/>
                </svg>
                @endif
            </div>
        </a>
    </div>
</header>

<nav class="bg-navy shadow-md sticky top-0 z-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-stretch h-16">
            <div class="hidden md:flex items-stretch flex-1 {{ $isRtl ? 'justify-end' : '' }}">
                @foreach($headerMenus as $menu)
                <div class="relative group flex">
                    <a href="{{ $menu->href }}" target="{{ $menu->target }}" rel="{{ $menu->target === '_blank' ? 'noopener noreferrer' : '' }}" class="flex items-center gap-1 px-4 text-sm font-medium border-b-2 transition-all whitespace-nowrap text-white/80 border-transparent hover:text-white hover:border-white/30">
                        {{ $menu->localized_title }}
                        @if($menu->children->isNotEmpty())
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        @endif
                    </a>
                    @if($menu->children->isNotEmpty())
                    <div class="absolute {{ $isRtl ? 'right-0' : 'left-0' }} top-full z-50 min-w-56 bg-white border border-gray-200 shadow-xl rounded-b-lg py-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-200">
                        @foreach($menu->children as $child)
                        <a href="{{ $child->href }}" target="{{ $child->target }}" rel="{{ $child->target === '_blank' ? 'noopener noreferrer' : '' }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-sea-light hover:text-navy transition-colors whitespace-nowrap">
                            {{ $child->localized_title }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if($showApplyButton)
            <div class="hidden md:flex items-center {{ $isRtl ? 'mr-auto' : 'ml-auto' }} px-2">
                <a href="{{ route('candidature.form') }}"
                   class="inline-flex items-center justify-center gap-1.5 px-5 py-2 bg-gold hover:bg-yellow-500 text-navy text-xs font-bold rounded-lg shadow-sm transition-all animate-pulse-slow">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>{{ $isRtl ? 'التسجيل / Inscription' : 'Inscription / التسجيل' }}</span>
                </a>
            </div>
            @endif

            <button id="nav-burger" class="md:hidden flex items-center px-4 text-white/80 hover:text-white" aria-controls="mobile-menu" aria-expanded="false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <span class="md:hidden flex-1 flex items-center text-white font-semibold text-base px-2">{{ $isRtl ? 'القائمة' : 'Menu' }}</span>

            @if($showLangSwitcher)
            <div class="md:hidden flex items-center gap-2 px-3 text-xs font-bold text-white/70 shrink-0">
                <a href="{{ route('lang.switch', 'fr') }}" class="{{ $currentLocale === 'fr' ? 'text-gold' : 'hover:text-white' }}">FR</a>
                <span class="text-white/25">|</span>
                <a href="{{ route('lang.switch', 'ar') }}" class="{{ $currentLocale === 'ar' ? 'text-gold' : 'hover:text-white' }}">العربية</a>
            </div>
            @endif
        </div>
    </div>

    <div id="mobile-menu" class="md:hidden bg-navy-dark border-t border-white/10" style="max-height: 0; overflow: hidden; transition: max-height 260ms ease;">
        <div class="px-4 py-2 space-y-0.5">
            @foreach($headerMenus as $menu)
            <a href="{{ $menu->href }}" target="{{ $menu->target }}" rel="{{ $menu->target === '_blank' ? 'noopener noreferrer' : '' }}" class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">
                {{ $menu->localized_title }}
            </a>
                @foreach($menu->children as $child)
                <a href="{{ $child->href }}" target="{{ $child->target }}" rel="{{ $child->target === '_blank' ? 'noopener noreferrer' : '' }}" class="block {{ $isRtl ? 'pr-7' : 'pl-7' }} px-3 py-2 text-xs text-white/55 hover:text-white hover:bg-white/10 rounded">
                    {{ $child->localized_title }}
                </a>
                @endforeach
            @endforeach
            @if($showApplyButton)
            <a href="{{ route('candidature.form') }}" class="block px-3 py-2.5 text-sm bg-gold text-navy font-bold rounded text-center">
                {{ $isRtl ? 'التسجيل / Inscription' : 'Inscription / التسجيل' }}
            </a>
            @endif
        </div>
    </div>
</nav>

@if(session('success'))
<div class="bg-green-600 text-white text-sm px-4 py-2.5">
    <div class="max-w-screen-xl mx-auto">{{ session('success') }}</div>
</div>
@endif

<main class="flex-1">
    @yield('content')
</main>

<footer class="bg-navy-dark text-white mt-0">
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 bg-gold rounded-full flex items-center justify-center shrink-0">
                        @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteSigle }}" class="w-full h-full object-contain rounded-full bg-white p-1">
                        @else
                        <svg class="w-5 h-5 text-navy" fill="currentColor" viewBox="0 0 24 24"><path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold text-white text-base">{{ $siteSigle }}</div>
                        @if($siteSlogan)<div class="text-gold text-xs">{{ $siteSlogan }}</div>@endif
                    </div>
                </div>
                @if($footerDescription)
                <p class="text-white/50 text-xs leading-relaxed">{{ $footerDescription }}</p>
                @endif
                @if($showSocial && $socialLinks)
                <div class="mt-4 flex flex-wrap gap-3 text-xs">
                    @foreach($socialLinks as $label => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-white/50 hover:text-gold">{{ $label }}</a>
                    @endforeach
                </div>
                @endif
            </div>

            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">Contact</h4>
                <ul class="space-y-3 text-xs text-white/60">
                    @if($siteAddress)<li>{{ $siteAddress }}</li>@endif
                    @if(!empty($layoutSettings['telephone']))<li>{{ $layoutSettings['telephone'] }}</li>@endif
                    @if(!empty($layoutSettings['email']))<li>{{ $layoutSettings['email'] }}</li>@endif
                    @if($siteHours)<li>{{ $siteHours }}</li>@endif
                </ul>
            </div>

            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">{{ $isRtl ? 'التنقل' : 'Navigation' }}</h4>
                <ul class="space-y-2 text-xs">
                    @foreach($footerMenus as $menu)
                    <li><a href="{{ $menu->href }}" target="{{ $menu->target }}" rel="{{ $menu->target === '_blank' ? 'noopener noreferrer' : '' }}" class="text-white/50 hover:text-gold transition-colors">{{ $menu->localized_title }}</a></li>
                        @foreach($menu->children as $child)
                        <li class="{{ $isRtl ? 'pr-4' : 'pl-4' }}"><a href="{{ $child->href }}" target="{{ $child->target }}" rel="{{ $child->target === '_blank' ? 'noopener noreferrer' : '' }}" class="text-white/35 hover:text-gold transition-colors">{{ $child->localized_title }}</a></li>
                        @endforeach
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">{{ $isRtl ? 'الموقع' : 'Localisation' }}</h4>
                <div class="rounded-lg overflow-hidden border border-white/10 bg-navy/50 h-32 flex items-center justify-center text-white/30 [&_iframe]:w-full [&_iframe]:h-full">
                    @if(!empty($layoutSettings['google_maps_embed']))
                        {!! $layoutSettings['google_maps_embed'] !!}
                    @else
                    <div class="text-center px-3">
                        <svg class="w-6 h-6 mx-auto mb-1 text-gold/40" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        <span class="text-xs">{{ $siteAddress ?: 'Nador, Maroc' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="max-w-screen-xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/30">
            <span>© {{ date('Y') }} {{ $siteSigle }} - {{ $copyrightText }}</span>
            <a href="{{ route('admin.login') }}" class="hover:text-white/60 transition-colors">Espace Administrateur</a>
        </div>
    </div>
</footer>

<script>
    const burger = document.getElementById('nav-burger');
    const mobileMenu = document.getElementById('mobile-menu');

    burger?.addEventListener('click', () => {
        const isOpen = mobileMenu.style.maxHeight && mobileMenu.style.maxHeight !== '0px';
        mobileMenu.style.maxHeight = isOpen ? '0px' : `${mobileMenu.scrollHeight}px`;
        burger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    });
</script>
</body>
</html>
