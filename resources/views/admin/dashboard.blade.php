@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble — CQPM Nador Administration')

@section('content')

{{-- ── Stats cards ─────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    @php
    $cards = [
        ['label'=>'Candidatures totales', 'value'=>$totalApplications, 'color'=>'navy',  'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'link'=>route('admin.applications.index')],
        ['label'=>'En attente',           'value'=>$pendingCount,       'color'=>'amber', 'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                        'link'=>route('admin.applications.index').'?status=En+attente'],
        ['label'=>'Validées',             'value'=>$validatedCount,     'color'=>'green', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                     'link'=>route('admin.applications.index').'?status=Valid%C3%A9'],
        ['label'=>'Documents PDF',        'value'=>$totalDocuments,     'color'=>'red',   'icon'=>'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',                      'link'=>route('admin.documents.index')],
    ];
    @endphp

    @foreach($cards as $c)
    <a href="{{ $c['link'] }}"
       class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-gray-300 transition-all group">
        <div class="flex items-start justify-between mb-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                {{ $c['color'] === 'navy' ? 'bg-blue-50' : ($c['color'] === 'amber' ? 'bg-amber-50' : ($c['color'] === 'green' ? 'bg-green-50' : 'bg-red-50')) }}">
                <svg class="w-5 h-5 {{ $c['color'] === 'navy' ? 'text-navy' : ($c['color'] === 'amber' ? 'text-amber-500' : ($c['color'] === 'green' ? 'text-green-600' : 'text-red-500')) }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}"/>
                </svg>
            </div>
        </div>
        <div class="text-2xl font-extrabold text-navy">{{ $c['value'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">{{ $c['label'] }}</div>
    </a>
    @endforeach

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Recent applications --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 text-sm">Dernières candidatures</h3>
            <a href="{{ route('admin.applications.index') }}" class="text-xs font-medium text-sea hover:text-navy transition-colors">Tout voir →</a>
        </div>
        @if($recentApplications->isEmpty())
        <div class="py-12 text-center">
            <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
            <p class="text-gray-400 text-sm">Aucune candidature pour le moment.</p>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach($recentApplications as $app)
            <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-gray-50 transition-colors">
                <div class="w-8 h-8 bg-navy/10 rounded-full flex items-center justify-center text-navy font-bold text-xs shrink-0">
                    {{ strtoupper(substr($app->prenom, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 text-sm truncate">{{ $app->full_name }}</div>
                    <div class="text-gray-400 text-xs truncate">{{ $app->section_candidature }}</div>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0
                    {{ $app->status === 'Validé' ? 'bg-green-100 text-green-700' : ($app->status === 'Rejeté' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ $app->status }}
                </span>
                <a href="{{ route('admin.applications.show', $app) }}" class="text-xs text-sea hover:text-navy font-medium transition-colors shrink-0">
                    Voir →
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Quick actions --}}
    <div class="space-y-4">

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 text-sm">Actions rapides</h3>
            </div>
            <div class="p-4 space-y-2">
                @php
                $actions = [
                    ['label'=>'Gérer les candidatures', 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2', 'href'=>route('admin.applications.index'), 'bg'=>'bg-blue-50 hover:bg-blue-100 text-navy'],
                    ['label'=>'Gérer les documents PDF', 'icon'=>'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12', 'href'=>route('admin.documents.index'), 'bg'=>'bg-red-50 hover:bg-red-100 text-red-700'],
                    ['label'=>'Paramètres du site', 'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'href'=>route('admin.site-settings.index'), 'bg'=>'bg-amber-50 hover:bg-amber-100 text-amber-700'],
                    ['label'=>'Voir le site public', 'icon'=>'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14', 'href'=>route('home'), 'bg'=>'bg-gray-50 hover:bg-gray-100 text-gray-700'],
                ];
                @endphp
                @foreach($actions as $a)
                <a href="{{ $a['href'] }}" @if(str_contains($a['label'],'site')) target="_blank" @endif
                   class="flex items-center gap-3 p-3 rounded-lg {{ $a['bg'] }} transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $a['icon'] }}"/>
                    </svg>
                    {{ $a['label'] }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Annonce preview --}}
        @if(($settings['annonce_active'] ?? '1') === '1')
        <div class="bg-gold-light border border-gold/30 rounded-xl p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/></svg>
                <span class="text-xs font-bold text-navy uppercase tracking-wide">Annonce active</span>
            </div>
            <p class="text-navy text-xs font-semibold leading-snug mb-1">{{ $settings['annonce_titre'] ?? '' }}</p>
            <a href="{{ route('admin.site-settings.index') }}" class="text-xs text-gold-dark hover:underline font-medium">Modifier les paramètres →</a>
        </div>
        @endif

    </div>
</div>

@endsection
