<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur — CQPM Nador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-navy min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        {{-- Brand --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-navy" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1C9.26 23.65 10.63 24 12 24s2.74-.35 4-1c1.26.65 2.63 1 4 1h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l1.89-6.68c.08-.26.06-.54-.06-.78s-.32-.42-.58-.5L20 10.62V6c0-1.1-.9-2-2-2h-3V1H9v3H6c-1.1 0-2 .9-2 2v4.62l-1.3.42c-.26.08-.46.26-.58.5s-.14.52-.06.78L3.95 19zM6 6h12v3.97L12 8 6 9.97V6z"/>
                </svg>
            </div>
            <h1 class="text-white font-bold text-xl">CQPM Nador</h1>
            <p class="text-white/50 text-sm mt-1">Espace Administrateur</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-navy font-bold text-lg mb-6 text-center">Connexion</h2>

            {{-- Error --}}
            @if($errors->has('credentials'))
            <div class="mb-5 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs text-red-600">{{ $errors->first('credentials') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 rounded-lg px-4 py-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs text-green-600">{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Adresse e-mail
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@cqpm-nador.ma"
                           class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">
                        Mot de passe
                    </label>
                    <input type="password" name="password" required
                           placeholder="••••••••••"
                           class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror rounded-lg px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition-all">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-navy hover:bg-navy-light text-white font-semibold rounded-lg text-sm transition-all shadow-sm">
                    Se connecter
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white/40 hover:text-white/70 text-xs transition-colors flex items-center justify-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour au site public
            </a>
        </div>
    </div>

</body>
</html>
