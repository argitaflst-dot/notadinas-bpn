<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Input Berkas') - Sistem Pembuatan Nota Dinas</title>

    {{-- Pakai Tailwind CDN biar langsung jalan tanpa build.
         Kalau project kamu sudah pakai Vite + Tailwind (Breeze),
         ganti baris ini dengan @vite(['resources/css/app.css','resources/js/app.js']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; }
    </style>
</head>
<body class="bg-[#EEEEEE]">

    <div class="flex flex-col h-screen overflow-hidden">

        {{-- HEADER --}}
        <header class="h-20 bg-[#003B7A] border-b-[3px] border-[#F5C542] flex items-center px-6 shrink-0 z-10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logobpn.png') }}" alt="Logo ATR/BPN"
     class="w-14 h-14 object-contain" onerror="this.style.display='none'">
                <div class="text-white leading-tight">
                    <p class="font-bold text-sm md:text-base">Kementerian Agraria dan Tata Ruang /</p>
                    <p class="font-bold text-sm md:text-base">Badan Pertanahan Nasional</p>
                    <p class="text-xs md:text-sm text-[#F5C542]">Kantor Pertanahan Kabupaten Cilacap</p>
                </div>
            </div>
            <div class="ml-auto text-white text-lg md:text-xl font-bold">
                Sistem Pembuatan Nota Dinas
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">

            {{-- SIDEBAR --}}
            <aside class="w-64 bg-[#003B7A] border-r-[3px] border-[#F5C542] shrink-0 overflow-y-auto">
                <nav class="py-6 px-4">
    <p class="text-[#F5C542] text-xs font-semibold tracking-wider mb-3 px-2">MENU</p>
    <ul class="space-y-3">

        {{-- Input Berkas --}}
        <li>
            <a href="{{ route('berkas.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition
                      {{ request()->routeIs('berkas.create') ? 'bg-white text-[#003B7A]' : 'text-white hover:bg-white/10' }}">
                {{-- file-add-outline --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="shrink-0">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                    <path d="M12 12v6"/>
                    <path d="M9 15h6"/>
                </svg>
                Input Berkas
            </a>
        </li>

        {{-- Pilih Berkas --}}
        <li>
            <a href="{{ Route::has('berkas.pilih') ? route('berkas.pilih') : '#' }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-white hover:bg-white/10 transition">
                {{-- file-check-alt --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="shrink-0">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                    <path d="m9 15 2 2 4-4"/>
                </svg>
                Pilih Berkas
            </a>
        </li>

        {{-- Riwayat --}}
        <li>
            <a href="{{ Route::has('berkas.riwayat') ? route('berkas.riwayat') : '#' }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-white hover:bg-white/10 transition">
                {{-- history-rounded --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="shrink-0">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
                Riwayat
            </a>
        </li>

    </ul>
</nav>
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 overflow-y-auto p-8 bg-[#EEEEEE]">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-100 text-green-800 text-sm px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>