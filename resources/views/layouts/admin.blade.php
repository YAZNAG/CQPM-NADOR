<!DOCTYPE html>
<html lang="fr">
<head>
    @php
        $adminSettings = \App\Models\SiteSetting::all_settings();
        $adminSigle = $adminSettings['sigle'] ?? 'CQPM Nador';
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') — {{ $adminSigle }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

<div class="min-h-screen flex">

    {{-- ── Sidebar ─────────────────────────────────────────────────────────── --}}
    <aside class="w-64 bg-navy-dark shrink-0 flex flex-col hidden lg:flex">
        {{-- Brand --}}
        <div class="p-6 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-navy" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">{{ $adminSigle }}</div>
                    <div class="text-gold text-xs">Administration</div>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>

            <a href="{{ route('admin.applications.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.applications.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Candidatures
                @php $count = \App\Models\Application::count(); @endphp
                @if($count > 0)
                <span class="ml-auto bg-gold text-navy text-xs font-bold px-2 py-0.5 rounded-full">{{ $count }}</span>
                @endif
            </a>

            <a href="{{ route('admin.documents.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.documents.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Documents PDF
            </a>

            <a href="{{ route('admin.news.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.news.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                Actualités
                @php $articleCount = \App\Models\Article::count(); @endphp
                @if($articleCount > 0)
                <span class="ml-auto bg-sea/20 text-sea text-xs font-bold px-2 py-0.5 rounded-full">{{ $articleCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.events.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Événements
                @php $eventCount = \App\Models\Event::count(); @endphp
                @if($eventCount > 0)
                <span class="ml-auto bg-sea/20 text-sea text-xs font-bold px-2 py-0.5 rounded-full">{{ $eventCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.media.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.media.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4a2 2 0 012.8 0l1.2 1.2L15 10a2 2 0 012.8 0L20 12.2M4 6h16v12H4z"/>
                </svg>
                Galerie médias
                @php $mediaCount = \App\Models\MediaItem::count(); @endphp
                @if($mediaCount > 0)
                <span class="ml-auto bg-sea/20 text-sea text-xs font-bold px-2 py-0.5 rounded-full">{{ $mediaCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.filieres.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.filieres.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Filières
                @php $filiereCount = \App\Models\Filiere::count(); @endphp
                @if($filiereCount > 0)
                <span class="ml-auto bg-gold/20 text-gold text-xs font-bold px-2 py-0.5 rounded-full">{{ $filiereCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.complaints.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.complaints.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Réclamations
                @php $complaintCount = \App\Models\Complaint::count(); @endphp
                @if($complaintCount > 0)
                <span class="ml-auto bg-gold/20 text-gold text-xs font-bold px-2 py-0.5 rounded-full">{{ $complaintCount }}</span>
                @endif
            </a>

            <div class="pt-4 mt-4 border-t border-white/10">
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-widest text-gold/80">Gestion du site</div>
            </div>

            <a href="{{ route('admin.menus.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.menus.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Menus
                @php $menuCount = \App\Models\Menu::count(); @endphp
                @if($menuCount > 0)
                <span class="ml-auto bg-white/10 text-white/70 text-xs font-bold px-2 py-0.5 rounded-full">{{ $menuCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.pages.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.pages.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h7l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z"/>
                </svg>
                Pages
                @php $pageCount = \App\Models\Page::count(); @endphp
                @if($pageCount > 0)
                <span class="ml-auto bg-white/10 text-white/70 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pageCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.sections.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.sections.*') || request()->routeIs('admin.pages.sections.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16M4 12h16M4 19h16"/>
                </svg>
                Sections
                @php $sectionCount = \App\Models\PageSection::count(); @endphp
                @if($sectionCount > 0)
                <span class="ml-auto bg-white/10 text-white/70 text-xs font-bold px-2 py-0.5 rounded-full">{{ $sectionCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.site-settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.settings.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11zm0 2c-2.761 0-5 1.79-5 4v1h10v-1c0-2.21-2.239-4-5-4z"/>
                </svg>
                Identité du site
            </a>

            <a href="{{ route('admin.pages.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M8 6h8m-8 0a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2"/>
                </svg>
                SEO
            </a>

            <a href="{{ route('admin.site-settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.settings.*') ? 'bg-navy text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>

            <div class="pt-4 border-t border-white/10 mt-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir le site public
                </a>
            </div>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-red-400 hover:bg-red-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main area ───────────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Administration')</h1>
                <p class="text-xs text-gray-500 mt-0.5">@yield('page-subtitle', 'Panneau d\'administration ' . $adminSigle)</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <span class="hidden sm:inline">admin@cqpm-nador.ma</span>
                <div class="w-8 h-8 bg-navy rounded-full flex items-center justify-center text-white text-xs font-bold">A</div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-6 mt-4 bg-green-50 border border-green-200 rounded-lg px-4 py-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mx-6 mt-4 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
