@extends('layouts.app')

@section('title', $page?->meta_title ?: ($page?->title ?: 'Accueil'))

@section('content')
    @php
        $siteSigle = $settings['sigle'] ?? 'CQPM Nador';
    @endphp

    @if($sections->isNotEmpty())
        @foreach($sections as $section)
            @include('pages._section', ['section' => $section])
        @endforeach
    @else
        <section class="py-20 bg-white">
            <div class="max-w-screen-xl mx-auto px-4 text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-navy mb-4">{{ $siteSigle }}</h1>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Le contenu de la page d’accueil sera affiché ici après création des sections depuis le dashboard.
                </p>
            </div>
        </section>
    @endif

    <script>
        document.querySelectorAll('[data-counter]').forEach((el) => {
            const raw = el.dataset.counter || '0';
            const target = parseInt(raw.replace(/\D/g, ''), 10) || 0;
            const suffix = raw.replace(/[0-9]/g, '');
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 45));
            const tick = () => {
                current = Math.min(target, current + step);
                el.textContent = current + suffix;
                if (current < target) requestAnimationFrame(tick);
            };
            tick();
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.cms-animate').forEach((el) => observer.observe(el));
    </script>
@endsection
