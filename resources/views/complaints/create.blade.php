@extends('layouts.app')
@section('title', 'Réclamations & Renseignements')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────────────────────── --}}
<section class="relative bg-navy overflow-hidden py-12 md:py-16">
    <div class="absolute inset-0" style="background: linear-gradient(135deg, #061E30 0%, #0B3C5D 60%, #1565A9 100%);"></div>
    <div class="absolute bottom-0 left-0 w-full opacity-10">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 720,0 1080,30 C1260,45 1380,15 1440,30 L1440,60 L0,60 Z" fill="white"/>
        </svg>
    </div>
    <div class="relative max-w-screen-xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 bg-gold/20 border border-gold/40 rounded-full px-4 py-1.5 mb-4">
            <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
            <span class="text-gold text-xs font-semibold tracking-widest uppercase">CQPM Nador</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">
            Réclamations & Renseignements
        </h1>
        <p class="text-white/60 text-sm max-w-xl mx-auto leading-relaxed">
            Vous avez une question ou souhaitez déposer une réclamation&nbsp;?
            Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.
        </p>
    </div>
</section>

{{-- ── Form ─────────────────────────────────────────────────────────────────── --}}
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Success flash --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-5 py-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-800 text-sm leading-relaxed">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            {{-- Card header --}}
            <div class="bg-navy px-6 py-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-gold/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-sm">Formulaire de contact</h2>
                    <p class="text-white/50 text-xs">Tous les champs sont obligatoires</p>
                </div>
            </div>

            {{-- Form body --}}
            <form method="POST" action="{{ route('reclamation.store') }}" class="p-6 space-y-5">
                @csrf

                {{-- Full name --}}
                <div>
                    <label for="full_name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                        Nom et prénom
                    </label>
                    <input id="full_name" name="full_name" type="text"
                           value="{{ old('full_name') }}"
                           placeholder="Ex: Mohammed Alami"
                           class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                                  {{ $errors->has('full_name') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                    @error('full_name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email + Phone row --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                            Adresse e-mail
                        </label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               placeholder="exemple@mail.com"
                               class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                                      {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                            Téléphone
                        </label>
                        <input id="phone" name="phone" type="text"
                               value="{{ old('phone') }}"
                               placeholder="06 XX XX XX XX"
                               class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                                      {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Subject --}}
                <div>
                    <label for="subject" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                        Objet de la réclamation
                    </label>
                    <input id="subject" name="subject" type="text"
                           value="{{ old('subject') }}"
                           placeholder="Ex: Demande de renseignements sur les formations"
                           class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition
                                  {{ $errors->has('subject') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                    @error('subject')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Message --}}
                <div>
                    <label for="message" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                        Message
                    </label>
                    <textarea id="message" name="message" rows="6"
                              placeholder="Décrivez votre réclamation ou votre demande de renseignements en détail..."
                              class="w-full px-4 py-2.5 rounded-lg border text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition resize-none
                                     {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Vous recevrez une réponse par e-mail ou par téléphone.</p>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-navy hover:bg-navy-dark text-white font-bold text-sm rounded-lg transition-all shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Envoyer
                    </button>
                </div>

            </form>
        </div>

        {{-- Info note --}}
        <div class="mt-6 bg-sea-light border border-sea/20 rounded-xl px-5 py-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-sea shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-navy mb-0.5">Délai de traitement</p>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Votre demande sera traitée par notre équipe dans les meilleurs délais.
                    Une réponse vous sera adressée par e-mail ou éventuellement par téléphone.
                </p>
            </div>
        </div>

    </div>
</section>

@endsection
