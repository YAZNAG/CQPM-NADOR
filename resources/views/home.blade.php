@extends('layouts.app')
@section('title', 'Accueil')

@section('content')

{{-- ══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ --}}
<section class="relative bg-navy overflow-hidden" style="min-height: 480px;">

    {{-- Layered background --}}
    <div class="absolute inset-0">
        {{-- Wave pattern --}}
        <svg class="absolute bottom-0 left-0 w-full opacity-10" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,60 C240,120 480,0 720,60 C960,120 1200,0 1440,60 L1440,120 L0,120 Z" fill="white"/>
        </svg>
        {{-- Gradient overlay --}}
        <div class="absolute inset-0" style="background: linear-gradient(135deg, #061E30 0%, #0B3C5D 50%, #1565A9 100%);"></div>
        {{-- Radial glow --}}
        <div class="absolute top-0 right-0 w-96 h-96 opacity-10 rounded-full" style="background: radial-gradient(circle, #C4992A, transparent); transform: translate(30%, -30%);"></div>
    </div>

    <div class="relative max-w-screen-xl mx-auto px-4 py-16 md:py-24 flex flex-col md:flex-row items-center gap-10">

        {{-- Text --}}
        <div class="flex-1 text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-gold/20 border border-gold/40 rounded-full px-4 py-1.5 mb-6">
                <span class="w-1.5 h-1.5 bg-gold rounded-full animate-pulse"></span>
                <span class="text-gold text-xs font-semibold tracking-widest uppercase">Inscriptions 2024 / 2025</span>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-5">
                Centre de Qualification<br>
                <span class="text-gold">Professionnelle Maritime</span><br>
                <span class="text-2xl md:text-3xl font-bold text-white/80">de Nador</span>
            </h1>

            <p class="text-white/65 text-base md:text-lg leading-relaxed mb-8 max-w-xl mx-auto md:mx-0">
                Formez-vous aux métiers de la mer dans un cadre agréé par le Département
                de la Pêche Maritime. Excellence, rigueur et insertion professionnelle garanties.
            </p>

            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                <a href="{{ route('candidature.form') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-gold hover:bg-gold-dark text-navy font-bold rounded text-sm transition-all shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    S'inscrire au Concours
                </a>
                <a href="#avis"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold border border-white/20 rounded text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Résultats & Avis
                </a>
            </div>
        </div>

        {{-- Stats panel --}}
        <div class="shrink-0 w-full md:w-64">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-5 grid grid-cols-2 gap-4">
                @foreach([
                    ['n'=>'+500', 'l'=>'Diplômés'],
                    ['n'=>'8',    'l'=>'Filières'],
                    ['n'=>'15+',  'l'=>"Ans d'expérience"],
                    ['n'=>'95%',  'l'=>'Insertion pro'],
                ] as $s)
                <div class="text-center">
                    <div class="text-2xl font-extrabold text-gold">{{ $s['n'] }}</div>
                    <div class="text-white/60 text-xs mt-0.5 leading-tight">{{ $s['l'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     ANNOUNCEMENT BANNER  (admin-controlled)
═══════════════════════════════════════════════════════ --}}
@if(($settings['annonce_active'] ?? '1') === '1')
<section class="bg-gold-light border-y border-gold/30">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <div class="flex items-center gap-2 shrink-0">
            <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/></svg>
            </div>
            <span class="font-bold text-navy text-sm shrink-0">Annonce :</span>
        </div>
        <div class="flex-1">
            <span class="font-semibold text-navy text-sm">{{ $settings['annonce_titre'] ?? '' }}</span>
            @if(!empty($settings['annonce_texte']))
            <span class="text-navy/70 text-sm ml-2">— {{ Str::limit($settings['annonce_texte'], 140) }}</span>
            @endif
        </div>
        <a href="#avis" class="text-xs font-bold text-navy underline underline-offset-2 hover:no-underline shrink-0">
            Voir les documents →
        </a>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════
     PRÉSENTATION DE L'INSTITUT
═══════════════════════════════════════════════════════ --}}
<section id="l-institut" class="py-14 bg-white">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">

            {{-- Text (3/5) --}}
            <div class="lg:col-span-3">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-1 h-8 bg-gold rounded-full"></div>
                    <span class="text-gold font-bold text-xs uppercase tracking-widest">L'Institut</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-navy mb-5 leading-snug">
                    Présentation du Centre de<br>Qualification Professionnelle Maritime
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Le <strong>Centre de Qualification Professionnelle Maritime de Nador (CQPM)</strong> est un
                    établissement public de formation professionnelle spécialisée, placé sous la tutelle du
                    <strong>Département de la Pêche Maritime</strong> du Royaume du Maroc.
                </p>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Situé dans la ville portuaire de Nador, le centre dispose d'un plateau technique moderne
                    comprenant simulateurs de navigation, ateliers machines, laboratoires maritimes et
                    installations de sécurité conformes aux standards STCW et aux conventions de l'Organisation
                    Maritime Internationale (OMI).
                </p>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    Notre mission est de former des <strong>professionnels qualifiés et compétents</strong>,
                    capables d'intégrer aussi bien la flotte de pêche nationale que les armements
                    internationaux, dans le respect des normes de sécurité maritime les plus exigeantes.
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach([
                        ['icon'=>'🎓', 'label'=>'Formation certifiée', 'sub'=>'Diplômes État'],
                        ['icon'=>'⚓', 'label'=>'Normes STCW', 'sub'=>'Standards OMI'],
                        ['icon'=>'🚢', 'label'=>'Stage embarqué', 'sub'=>'Flotte nationale'],
                        ['icon'=>'💼', 'label'=>'Insertion pro', 'sub'=>'Réseau employeurs'],
                    ] as $item)
                    <div class="text-center p-3 bg-sea-light rounded-lg border border-sea/10">
                        <div class="text-2xl mb-1">{{ $item['icon'] }}</div>
                        <div class="text-xs font-semibold text-navy">{{ $item['label'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $item['sub'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Visual panel (2/5) --}}
            <div class="lg:col-span-2">
                <div class="bg-navy rounded-xl overflow-hidden shadow-xl">
                    <div class="bg-navy-dark px-5 py-3 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-gold"></div>
                        <span class="text-white/70 text-xs font-medium">Informations clés</span>
                    </div>
                    <div class="p-5 space-y-4">
                        @foreach([
                            ['label'=>'Statut', 'val'=>'Établissement public sous tutelle'],
                            ['label'=>'Tutelle', 'val'=>'Département de la Pêche Maritime'],
                            ['label'=>'Ville', 'val'=>'Nador, Région de l\'Oriental'],
                            ['label'=>'Langue', 'val'=>'Arabe & Français'],
                            ['label'=>'Durée formations', 'val'=>'6 semaines à 24 mois'],
                            ['label'=>'Capacité annuelle', 'val'=>'~150 stagiaires'],
                        ] as $row)
                        <div class="flex items-start gap-3 py-2 border-b border-white/10 last:border-0">
                            <span class="text-gold text-xs font-semibold w-28 shrink-0">{{ $row['label'] }}</span>
                            <span class="text-white/70 text-xs">{{ $row['val'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     MOT DU DIRECTEUR
═══════════════════════════════════════════════════════ --}}
<section id="mot-directeur" class="py-14 bg-gray-50 border-t border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-center">

            {{-- Left column: Director photo placeholder (2/5) --}}
            <div class="lg:col-span-2 flex justify-center lg:justify-start">
                <div class="relative w-64 lg:w-full max-w-xs">
                    {{-- Decorative background block --}}
                    <div class="absolute -bottom-3 -right-3 w-full h-full rounded-2xl border-2 border-gold/40 bg-navy/5"></div>
                    {{-- Photo frame --}}
                    <div class="relative bg-white border-2 border-gray-200 rounded-2xl shadow-xl overflow-hidden aspect-[3/4]">
                        {{-- Gradient background placeholder --}}
                        <div class="absolute inset-0" style="background: linear-gradient(160deg, #0B3C5D 0%, #1565A9 60%, #1A7FAE 100%);"></div>
                        {{-- Subtle wave overlay --}}
                        <svg class="absolute bottom-0 left-0 w-full opacity-20" viewBox="0 0 300 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0,40 C75,80 150,0 225,40 C270,65 290,30 300,40 L300,80 L0,80 Z" fill="white"/>
                        </svg>
                        {{-- Silhouette icon --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-3">
                            <div class="w-24 h-24 rounded-full bg-white/15 border-2 border-white/30 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/60" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                            <p class="text-white/50 text-xs text-center px-4 leading-snug">Photo du Directeur<br><span class="text-white/30 text-[10px]">à remplacer</span></p>
                        </div>
                        {{-- Name plate at bottom --}}
                        <div class="absolute bottom-0 left-0 right-0 bg-navy/70 backdrop-blur-sm px-4 py-3 text-center">
                            <p class="text-white font-bold text-sm leading-tight">M. [Prénom Nom]</p>
                            <p class="text-gold text-xs mt-0.5">Directeur du CQPM Nador</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column: Message text (3/5) --}}
            <div class="lg:col-span-3">
                {{-- Section label --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-8 bg-gold rounded-full"></div>
                    <span class="text-gold font-bold text-xs uppercase tracking-widest">Éditorial</span>
                </div>

                {{-- Heading --}}
                <h2 class="text-2xl md:text-3xl font-bold text-navy mb-4 leading-snug">
                    Mot du Directeur
                </h2>

                {{-- Gold separator --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-px flex-1 max-w-[60px] bg-gold"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-gold"></div>
                    <div class="h-px flex-1 max-w-[60px] bg-gold/30"></div>
                </div>

                {{-- Opening quote --}}
                <div class="relative pl-5 mb-6 border-l-2 border-gold/50">
                    <svg class="absolute -top-1 -left-2 w-4 h-4 text-gold/40" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.95.78-3 .53-.81 1.24-1.46 2.13-1.95l-1.04-1.52C8.09 7.1 7.18 7.86 6.42 8.83c-.87 1.1-1.44 2.3-1.7 3.6-.27 1.3-.2 2.53.2 3.7.42 1.17 1.15 2.07 2.2 2.7 1.05.63 2.17.8 3.36.52.83-.2 1.46-.6 1.9-1.2.44-.6.65-1.3.62-2.12zm9.83 0c0-.88-.23-1.618-.69-2.217-.326-.42-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.95.78-3 .53-.81 1.24-1.46 2.13-1.95l-1.04-1.52c-1.41.97-2.32 1.73-3.08 2.7-.87 1.1-1.44 2.3-1.7 3.6-.27 1.3-.2 2.53.2 3.7.42 1.17 1.15 2.07 2.2 2.7 1.05.63 2.17.8 3.36.52.83-.2 1.46-.6 1.9-1.2.44-.6.65-1.3.62-2.12z"/>
                    </svg>
                    <p class="text-gray-700 text-sm leading-relaxed italic">
                        Bienvenue au Centre de Qualification Professionnelle Maritime de Nador.
                        Notre établissement œuvre sans relâche pour former des marins et des techniciens
                        de la mer compétents, engagés et fiers de servir la flotte maritime nationale.
                    </p>
                </div>

                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Fondé sur des valeurs d'excellence, de rigueur professionnelle et d'ouverture sur
                    le monde maritime international, le CQPM Nador constitue un pilier fondamental de la
                    formation maritime au Maroc. Nos programmes, conformes aux standards de l'Organisation
                    Maritime Internationale (OMI) et aux conventions STCW, garantissent à nos lauréats
                    une insertion professionnelle réussie.
                </p>

                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    Je vous invite à parcourir notre offre de formation et à rejoindre notre communauté
                    d'apprenants passionnés par la mer. Ensemble, construisons l'avenir du secteur
                    maritime marocain.
                </p>

                {{-- Signature --}}
                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-navy flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-navy font-bold text-sm">M. [Prénom Nom]</p>
                        <p class="text-gray-400 text-xs">Directeur du CQPM Nador</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     NOS FORMATIONS
═══════════════════════════════════════════════════════ --}}
<section id="formations" class="py-14 bg-white border-t border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">

        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-px bg-gold"></div>
                <span class="text-gold font-bold text-xs uppercase tracking-widest">Nos programmes</span>
                <div class="w-8 h-px bg-gold"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-navy">Filières de Formation</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">
                Des formations agréées, dispensées par des formateurs-experts du secteur maritime.
            </p>
        </div>

        @php
        $formations = [
            ['emoji'=>'🧭','titre'=>'Navigation Maritime', 'badge'=>'Brevet de Patron',       'duree'=>'24 mois', 'desc'=>'Navigation côtière et hauturière, cartographie, météorologie marine, règlement international pour prévenir les abordages.'],
            ['emoji'=>'⚙️','titre'=>'Machine Maritime',    'badge'=>'Brevet de Mécanicien',    'duree'=>'24 mois', 'desc'=>'Conduite et maintenance des moteurs diesel marins, systèmes électriques, hydrauliques et de réfrigération embarqués.'],
            ['emoji'=>'🎣','titre'=>'Pêche Artisanale',    'badge'=>'Certificat Professionnel', 'duree'=>'12 mois', 'desc'=>'Techniques de pêche côtière, identification des espèces, gestion des captures, réglementation halieutique nationale.'],
            ['emoji'=>'🛟','titre'=>'Sécurité Maritime',   'badge'=>'STCW de base',            'duree'=>'6 semaines','desc'=>'Techniques de survie en mer, lutte anti-incendie, PMAN, premiers secours médicaux, GMDSS/VHF.'],
            ['emoji'=>'🐟','titre'=>'Aquaculture',         'badge'=>'Technicien Spécialisé',   'duree'=>'18 mois', 'desc'=>'Élevage de poissons et coquillages, gestion des installations aquacoles côtières, qualité et traçabilité des produits.'],
            ['emoji'=>'🏭','titre'=>'Transformation',      'badge'=>'Certificat Professionnel','duree'=>'12 mois', 'desc'=>'Valorisation des produits de la mer, procédés HACCP, conditionnement, chaîne du froid et normes d\'hygiène.'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($formations as $f)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg hover:border-navy/20 transition-all group">
                <div class="h-1.5 bg-navy group-hover:bg-gold transition-colors"></div>
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-11 h-11 bg-sea-light rounded-lg flex items-center justify-center text-xl shrink-0">{{ $f['emoji'] }}</div>
                        <div>
                            <h3 class="font-bold text-navy text-sm group-hover:text-sea transition-colors leading-tight">{{ $f['titre'] }}</h3>
                            <span class="text-xs bg-navy/10 text-navy px-2 py-0.5 rounded font-medium">{{ $f['badge'] }}</span>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed mb-4">{{ $f['desc'] }}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $f['duree'] }}
                        </span>
                        <a href="{{ route('candidature.form') }}"
                           class="text-xs font-bold text-gold hover:text-gold-dark transition-colors flex items-center gap-1">
                            Postuler
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('candidature.form') }}"
               class="inline-flex items-center gap-2 px-8 py-3 bg-navy hover:bg-navy-light text-white font-bold rounded text-sm transition-all shadow-md">
                Déposer ma candidature
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     ACTUALITÉS & ÉVÉNEMENTS
═══════════════════════════════════════════════════════ --}}
<section id="actualites" class="py-14 bg-gray-50 border-t border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">

        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-px bg-gold"></div>
                <span class="text-gold font-bold text-xs uppercase tracking-widest">Vie du centre</span>
                <div class="w-8 h-px bg-gold"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-navy">Actualités & Événements</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">
                Suivez les dernières nouvelles, annonces et événements du CQPM Nador.
            </p>
        </div>

        @if($articles->isEmpty())
        <div class="max-w-lg mx-auto text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <p class="text-gray-400 text-sm font-medium">Aucune actualité publiée pour le moment.</p>
            <p class="text-gray-300 text-xs mt-1">Revenez prochainement pour suivre nos actualités.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($articles as $article)
            <article class="group bg-white border border-gray-200 hover:border-navy/20 rounded-xl overflow-hidden hover:shadow-lg transition-all flex flex-col">

                {{-- Card top accent --}}
                <div class="h-1 bg-navy group-hover:bg-gold transition-colors shrink-0"></div>

                {{-- Image preview (if attached image) --}}
                @if($article->file_path && $article->isImage())
                <div class="w-full h-40 overflow-hidden bg-gray-100 shrink-0">
                    <img src="{{ $article->file_url }}"
                         alt="{{ $article->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif

                <div class="p-5 flex flex-col flex-1">

                    {{-- Date badge --}}
                    <div class="flex items-center gap-1.5 mb-3">
                        <svg class="w-3.5 h-3.5 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <time class="text-xs font-semibold text-gold">
                            {{ $article->created_at->format('d/m/Y') }}
                        </time>
                        @if($article->file_path && $article->isPdf())
                        <span class="ml-auto inline-flex items-center gap-1 text-xs bg-red-50 text-red-600 font-medium px-1.5 py-0.5 rounded">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8Z"/></svg>
                            PDF joint
                        </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h3 class="font-bold text-navy text-sm leading-snug mb-2 group-hover:text-sea transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>

                    {{-- Excerpt --}}
                    <p class="text-gray-500 text-xs leading-relaxed flex-1 mb-4 line-clamp-3">
                        {{ Str::limit($article->content, 130) }}
                    </p>

                    {{-- CTA --}}
                    <a href="{{ route('news.show', $article) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-gold hover:text-gold-dark transition-colors mt-auto">
                        Lire la suite
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     AVIS & RÉSULTATS (dynamic PDF downloads)
═══════════════════════════════════════════════════════ --}}
<section id="avis" class="py-14 bg-white border-t border-gray-200">
    <div class="max-w-screen-xl mx-auto px-4">

        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-px bg-gold"></div>
                <span class="text-gold font-bold text-xs uppercase tracking-widest">Téléchargements</span>
                <div class="w-8 h-px bg-gold"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-navy">Avis & Résultats</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">
                Consultez et téléchargez les listes des admis, les avis de concours et les formulaires officiels.
            </p>
        </div>

        @if($documents->isEmpty())
        <div class="max-w-lg mx-auto text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-400 text-sm font-medium">Aucun document publié pour le moment.</p>
            <p class="text-gray-300 text-xs mt-1">Revenez prochainement pour consulter les avis et résultats.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($documents as $doc)
            <div class="group flex flex-col bg-white border border-gray-200 hover:border-navy/30 rounded-xl overflow-hidden hover:shadow-md transition-all">
                {{-- PDF header --}}
                <div class="bg-red-600 px-4 py-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8ZM18,20H6V4h7V9h5ZM11,14H9V16H11Zm4-4H9v2H15Zm0,4H13V16H15Z"/>
                    </svg>
                    <span class="text-white text-xs font-bold tracking-wide uppercase">PDF</span>
                </div>
                {{-- Content --}}
                <div class="flex-1 p-4 flex flex-col">
                    <h3 class="font-semibold text-navy text-sm leading-snug mb-2 group-hover:text-sea transition-colors">
                        {{ $doc->title }}
                    </h3>
                    <p class="text-gray-400 text-xs mb-4 flex-1">
                        Publié le {{ $doc->created_at->format('d/m/Y') }}
                    </p>
                    <a href="{{ $doc->public_url }}" target="_blank" download
                       class="flex items-center justify-center gap-2 w-full py-2 bg-navy hover:bg-gold hover:text-navy text-white text-xs font-bold rounded transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Télécharger
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     CTA STRIP
═══════════════════════════════════════════════════════ --}}
<section class="bg-navy py-12">
    <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div>
            <h3 class="text-xl font-bold text-white mb-1">Prêt à rejoindre la famille CQPM ?</h3>
            <p class="text-white/60 text-sm">Les inscriptions au concours 2024/2025 sont ouvertes. Ne manquez pas cette opportunité.</p>
        </div>
        <div class="flex flex-wrap gap-3 justify-center md:justify-end">
            <a href="{{ route('candidature.form') }}"
               class="shrink-0 inline-flex items-center gap-2 px-8 py-3.5 bg-gold hover:bg-gold-dark text-navy font-bold rounded text-sm transition-all shadow-lg whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                S'inscrire maintenant
            </a>
            <a href="{{ route('reclamation.form') }}"
               class="shrink-0 inline-flex items-center gap-2 px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white font-semibold border border-white/25 rounded text-sm transition-all whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Envoyer une réclamation
            </a>
        </div>
    </div>
</section>

@endsection
