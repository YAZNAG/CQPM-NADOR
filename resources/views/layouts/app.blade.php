<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Centre de Qualification Professionnelle Maritime de Nador — Formation maritime professionnelle agréée par le Département de la Pêche Maritime.">
    <title>@yield('title', 'Accueil') — CQPM Nador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

{{-- ══════════════════════════════════════════════════════
     TOP MICRO-BAR  (contact + socials)
═══════════════════════════════════════════════════════ --}}
<div class="bg-navy-dark text-white/70 text-sm hidden md:block">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="tel:+212536000000" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                +212 (0) 536 XX XX XX
            </a>
            <a href="mailto:contact@cqpm-nador.ma" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                contact@cqpm-nador.ma
            </a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-white/30">|</span>
            <a href="#" aria-label="Facebook" class="hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="#" aria-label="YouTube" class="hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     LOGO HEADER  (institutional logos)
═══════════════════════════════════════════════════════ --}}
<header class="bg-white border-b border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4 py-6 md:py-7 flex items-center justify-between gap-6">

        {{-- Left: Government logos --}}
        <div class="flex items-center gap-4 shrink-0">
            {{-- Morocco Royal Seal --}}
            <div class="flex flex-col items-center text-center w-20 shrink-0">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-2 border-navy/20 flex items-center justify-center bg-white shadow-md">
                    <svg viewBox="0 0 80 80" class="w-13 h-13 md:w-16 md:h-16" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="38" fill="none" stroke="#0B3C5D" stroke-width="2"/>
                        <polygon points="40,8 46,30 68,30 51,44 57,66 40,52 23,66 29,44 12,30 34,30" fill="#C4992A" stroke="#A07820" stroke-width="1"/>
                        <circle cx="40" cy="40" r="8" fill="#0B3C5D"/>
                    </svg>
                </div>
                <span class="text-[11px] text-navy font-semibold leading-tight mt-1.5">Royaume<br>du Maroc</span>
            </div>
            <div class="h-16 md:h-20 w-px bg-gray-200 hidden sm:block"></div>
            {{-- Ministry label --}}
            <div class="hidden sm:flex flex-col justify-center pl-1 gap-0.5">
                <span class="text-xs font-bold text-navy uppercase leading-snug tracking-wide">Ministère de l'Agriculture</span>
                <span class="text-xs text-gray-500 leading-snug">de la Pêche Maritime, du</span>
                <span class="text-xs text-gray-500 leading-snug">Dév. Rural et des Eaux et Forêts</span>
            </div>
        </div>

        {{-- Center: Site name (mobile-visible) --}}
        <a href="{{ route('home') }}" class="flex-1 text-center lg:hidden">
            <div class="font-bold text-navy text-lg leading-tight">CQPM Nador</div>
            <div class="text-sm text-gray-400 mt-0.5">Centre de Qualification Maritime</div>
        </a>

        {{-- Right: Institute logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-4 shrink-0 group">
            <div class="text-right hidden lg:block">
                <div class="font-extrabold text-navy text-2xl leading-tight tracking-tight">CQPM Nador</div>
                <div class="text-sm text-gray-500 mt-0.5">Centre de Qualification Professionnelle Maritime</div>
                <div class="text-sm text-gray-400 mt-0.5" style="font-family: Arial, sans-serif;">مركز التأهيل المهني البحري — الناظور</div>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 bg-navy rounded-full flex items-center justify-center shadow-lg group-hover:bg-navy-light transition-colors shrink-0">
                <svg class="w-8 h-8 md:w-10 md:h-10 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l1.89-6.68c.08-.26.06-.54-.06-.78s-.32-.42-.58-.5L20 10.62V6c0-1.1-.9-2-2-2h-3V1H9v3H6c-1.1 0-2 .9-2 2v4.62l-1.3.42c-.26.08-.46.26-.58.5s-.14.52-.06.78L3.95 19zM6 6h12v3.97L12 8 6 9.97V6z"/>
                </svg>
            </div>
        </a>
    </div>
</header>

{{-- ══════════════════════════════════════════════════════
     NAVIGATION BAR
═══════════════════════════════════════════════════════ --}}
<nav class="bg-navy shadow-md sticky top-0 z-50">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-stretch h-16">

            {{-- Desktop nav links --}}
            <div class="hidden md:flex items-stretch flex-1">
                @php
                $navLinks = [
                    ['route' => 'home', 'label' => 'Accueil',           'hash' => ''],
                    ['route' => 'home', 'label' => "L'Institut",        'hash' => '#l-institut'],
                    ['route' => 'home', 'label' => 'Formations',        'hash' => '#formations'],
                    ['route' => 'home', 'label' => 'Mot du Directeur',  'hash' => '#mot-directeur'],
                    ['route' => 'home', 'label' => 'Actualités & News', 'hash' => '#actualites'],
                    ['route' => 'home', 'label' => 'Avis & Résultats',  'hash' => '#avis'],
                ];
                @endphp

                @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}{{ $link['hash'] }}"
                   class="flex items-center px-4 text-sm font-medium border-b-2 transition-all whitespace-nowrap
                          {{ (request()->routeIs($link['route']) && $link['hash'] === '')
                              ? 'text-gold border-gold'
                              : 'text-white/80 border-transparent hover:text-white hover:border-white/30' }}">
                    {{ $link['label'] }}
                </a>
                @endforeach
            </div>

            {{-- Mobile burger --}}
            <button id="nav-burger" class="md:hidden flex items-center px-4 text-white/80 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="md:hidden flex-1 flex items-center text-white font-semibold text-base px-2">Menu</span>

            {{-- CTA inscription --}}
            <a href="{{ route('candidature.form') }}"
               class="flex items-center gap-2 px-7 bg-gold hover:bg-gold-dark text-navy font-bold text-sm transition-colors shrink-0">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Inscription
            </a>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-navy-dark border-t border-white/10">
        <div class="px-4 py-2 space-y-0.5">
            <a href="{{ route('home') }}"                  class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">Accueil</a>
            <a href="{{ route('home') }}#l-institut"      class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">L'Institut</a>
            <a href="{{ route('home') }}#formations"      class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">Formations</a>
            <a href="{{ route('home') }}#mot-directeur"   class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">Mot du Directeur</a>
            <a href="{{ route('home') }}#actualites"      class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">Actualités &amp; News</a>
            <a href="{{ route('home') }}#avis"            class="block px-3 py-2.5 text-sm text-white/80 hover:text-white hover:bg-white/10 rounded">Avis &amp; Résultats</a>
            <a href="{{ route('candidature.form') }}"     class="block mx-3 mt-2 px-3 py-2.5 bg-gold text-navy font-bold text-sm rounded text-center">Inscription au Concours</a>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════════════════
     FLASH MESSAGES
═══════════════════════════════════════════════════════ --}}
@if(session('success'))
<div class="bg-green-600 text-white text-sm px-4 py-2.5">
    <div class="max-w-screen-xl mx-auto flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════════════ --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════ --}}
<footer class="bg-navy-dark text-white mt-0">

    {{-- Main footer content --}}
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Col 1: Brand --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 bg-gold rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-navy" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-white text-base">CQPM Nador</div>
                        <div class="text-gold text-xs">Qualification Maritime</div>
                    </div>
                </div>
                <p class="text-white/50 text-xs leading-relaxed">
                    Établissement de formation professionnelle maritime agréé, placé sous la tutelle du Département de la Pêche Maritime du Maroc.
                </p>
            </div>

            {{-- Col 2: Contact --}}
            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">Contact</h4>
                <ul class="space-y-3 text-xs text-white/60">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-3.5 h-3.5 text-gold mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        Port de Nador, Avenue Mohammed VI<br>Nador 62000, Maroc
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        +212 (0) 536 XX XX XX
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        contact@cqpm-nador.ma
                    </li>
                </ul>
            </div>

            {{-- Col 3: Quick links --}}
            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">Navigation</h4>
                <ul class="space-y-2 text-xs">
                    @foreach([
                        ['url' => route('home'),                    'label' => 'Accueil'],
                        ['url' => route('home').'#l-institut',      'label' => "Présentation de l'Institut"],
                        ['url' => route('home').'#mot-directeur',   'label' => 'Mot du Directeur'],
                        ['url' => route('home').'#formations',      'label' => 'Nos Formations'],
                        ['url' => route('home').'#actualites',      'label' => 'Actualités & News'],
                        ['url' => route('home').'#avis',            'label' => 'Avis & Résultats'],
                        ['url' => route('candidature.form'),        'label' => 'Inscription au Concours'],
                    ] as $link)
                    <li>
                        <a href="{{ $link['url'] }}" class="text-white/50 hover:text-gold transition-colors flex items-center gap-1.5">
                            <svg class="w-2.5 h-2.5 text-gold/60" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 4: Map placeholder --}}
            <div>
                <h4 class="text-gold font-semibold text-xs uppercase tracking-widest mb-4">Localisation</h4>
                <div class="rounded-lg overflow-hidden border border-white/10 bg-navy/50 h-32 flex items-center justify-center text-white/30">
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto mb-1 text-gold/40" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        <span class="text-xs">Port de Nador, Maroc</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-screen-xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/30">
            <span>© {{ date('Y') }} CQPM Nador — Tous droits réservés — Département de la Pêche Maritime, Maroc</span>
            <a href="{{ route('admin.login') }}" class="hover:text-white/60 transition-colors">Espace Administrateur</a>
        </div>
    </div>
</footer>

<script>
    document.getElementById('nav-burger')?.addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
</body>
</html>
