@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'الشكايات والمعلومات' : 'Réclamations & Renseignements')

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $siteSigle = $settings['sigle'] ?? 'CQPM Nador';
    $address = $isRtl ? ($settings['adresse_ar'] ?? '') : ($settings['adresse_fr'] ?? '');
    $hours = $isRtl ? ($settings['horaires_ar'] ?? '') : ($settings['horaires_fr'] ?? '');
@endphp

<section class="relative bg-navy overflow-hidden py-12 md:py-16">
    <div class="absolute inset-0" style="background: linear-gradient(135deg, #061E30 0%, #0B3C5D 60%, #1565A9 100%);"></div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 bg-gold/20 border border-gold/40 rounded-full px-4 py-1.5 mb-4">
            <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
            <span class="text-gold text-xs font-semibold tracking-widest uppercase">{{ $siteSigle }}</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">
            {{ $isRtl ? 'الشكايات والمعلومات' : 'Réclamations & Renseignements' }}
        </h1>
        <p class="text-white/60 text-sm max-w-xl mx-auto leading-relaxed">
            {{ $isRtl ? 'هل لديك سؤال أو ترغب في تقديم شكاية؟ املأ النموذج أدناه وسنجيبك في أقرب الآجال.' : 'Vous avez une question ou souhaitez déposer une réclamation ? Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.' }}
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-4 text-sm text-green-800">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <h2 class="text-white font-bold text-sm">{{ $isRtl ? 'نموذج الاتصال' : 'Formulaire de contact' }}</h2>
                    <p class="text-white/50 text-xs mt-1">{{ $isRtl ? 'يرجى ملء جميع الحقول المطلوبة' : 'Tous les champs sont obligatoires' }}</p>
                </div>

                <form method="POST" action="{{ route('reclamation.store') }}" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label for="full_name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">{{ $isRtl ? 'الاسم الكامل' : 'Nom et prénom' }}</label>
                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" class="w-full px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 {{ $errors->has('full_name') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        @error('full_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">{{ $isRtl ? 'البريد الإلكتروني' : 'Adresse e-mail' }}</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">{{ $isRtl ? 'الهاتف' : 'Téléphone' }}</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">{{ $isRtl ? 'الموضوع' : 'Objet de la réclamation' }}</label>
                        <input id="subject" name="subject" type="text" value="{{ old('subject') }}" class="w-full px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 {{ $errors->has('subject') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">{{ $isRtl ? 'الرسالة' : 'Message' }}</label>
                        <textarea id="message" name="message" rows="6" class="w-full px-4 py-2.5 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-navy/30 resize-none {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end pt-2 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-dark text-white font-bold text-sm rounded-lg transition-all shadow">
                            {{ $isRtl ? 'إرسال' : 'Envoyer' }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-sea-light border border-sea/20 rounded-xl px-5 py-4">
                <p class="text-sm font-semibold text-navy mb-1">{{ $isRtl ? 'مدة المعالجة' : 'Délai de traitement' }}</p>
                <p class="text-xs text-gray-600 leading-relaxed">
                    {{ $isRtl ? 'سيتم التعامل مع طلبكم في أقرب الآجال، وسيتم التواصل معكم عبر البريد الإلكتروني أو الهاتف.' : 'Votre demande sera traitée par notre équipe dans les meilleurs délais. Une réponse vous sera adressée par e-mail ou éventuellement par téléphone.' }}
                </p>
            </div>
        </div>

        <aside class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 space-y-5">
            <div>
                <h2 class="text-sm font-bold text-navy mb-3">{{ $isRtl ? 'معلومات الاتصال' : 'Coordonnées' }}</h2>
                <div class="space-y-3 text-sm text-gray-600">
                    @if($address)<p>{{ $address }}</p>@endif
                    @if(!empty($settings['telephone']))<p>{{ $settings['telephone'] }}</p>@endif
                    @if(!empty($settings['email']))<p>{{ $settings['email'] }}</p>@endif
                    @if($hours)<p>{{ $hours }}</p>@endif
                </div>
            </div>
            @if(!empty($settings['google_maps_embed']))
            <div class="rounded-xl overflow-hidden border border-gray-200 [&_iframe]:w-full [&_iframe]:h-48">
                {!! $settings['google_maps_embed'] !!}
            </div>
            @endif
        </aside>
    </div>
</section>

@endsection
