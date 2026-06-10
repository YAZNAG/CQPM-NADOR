@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)

@section('content')
    @if($page->content)
        <section class="bg-white border-b border-gray-200">
            <div class="max-w-screen-xl mx-auto px-4 py-12">
                <div class="max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-navy mb-4">{{ $page->title }}</h1>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $page->content }}</p>
                </div>
            </div>
        </section>
    @endif

    @foreach($sections as $section)
        @include('pages._section', ['section' => $section])
    @endforeach

    @if($sections->isEmpty() && ! $page->content)
        <section class="py-20 bg-white">
            <div class="max-w-screen-xl mx-auto px-4 text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-navy mb-4">{{ $page->title }}</h1>
                <p class="text-gray-500">{{ app()->getLocale() === 'ar' ? 'لم يتم إضافة محتوى لهذه الصفحة بعد.' : 'Aucun contenu n’a encore été ajouté à cette page.' }}</p>
            </div>
        </section>
    @endif

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) entry.target.classList.add('is-visible');
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.cms-animate').forEach((el) => observer.observe(el));
    </script>
@endsection
