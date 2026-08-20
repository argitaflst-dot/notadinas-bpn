<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Input Berkas') - Sistem Pembuatan Nota Dinas</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Iconify --}}
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <style>
        html,
        body {
            font-family: 'Inter', sans-serif !important;
        }

        header,
        header *,
        aside,
        aside *,
        main,
        main * {
            font-family: 'Inter', sans-serif !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#EEEEEE]">

    <div class="flex flex-col h-screen overflow-hidden">

        {{-- HEADER --}}
        <header class="h-20 bg-[#003B7A] border-b-[3px] border-[#F5C542] flex items-center px-6 shrink-0 z-10">

            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('images/logobpn.png') }}"
                    alt="Logo ATR/BPN"
                    class="w-14 h-14 object-contain"
                    onerror="this.style.display='none'"
                >

                <div class="text-white leading-tight">
                    <p class="font-bold text-sm md:text-base">
                        Kementerian Agraria dan Tata Ruang /
                    </p>

                    <p class="font-bold text-sm md:text-base">
                        Badan Pertanahan Nasional
                    </p>

                    <p class="text-xs md:text-sm text-[#F5C542]">
                        Kantor Pertanahan Kabupaten Cilacap
                    </p>
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

                    <p class="text-[#F5C542] text-xs font-semibold tracking-wider mb-3 px-2">
                        MENU
                    </p>

                    <ul class="space-y-3">

                        {{-- Input Berkas --}}
                        <li>
                            <a
                                href="{{ route('berkas.create') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold transition
                                {{ request()->routeIs('berkas.create')
                                    ? 'bg-white text-[#003B7A]'
                                    : 'text-white hover:bg-white/10' }}"
                            >

                                <iconify-icon
                                    icon="mdi:file-plus-outline"
                                    width="22"
                                    height="22"
                                ></iconify-icon>

                                Input Berkas
                            </a>
                        </li>


                        {{-- Pilih Berkas --}}
                        <li>
                            <a
                                href="{{ Route::has('berkas.pilih') ? route('berkas.pilih') : '#' }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-white hover:bg-white/10 transition"
                            >

                                <iconify-icon
                                    icon="mdi:file-check-outline"
                                    width="22"
                                    height="22"
                                ></iconify-icon>

                                Pilih Berkas
                            </a>
                        </li>


                        {{-- Riwayat --}}
                        <li>
                            <a
                                href="{{ Route::has('berkas.riwayat') ? route('berkas.riwayat') : '#' }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-semibold text-white hover:bg-white/10 transition"
                            >

                                <iconify-icon
                                    icon="material-symbols:history-rounded"
                                    width="22"
                                    height="22"
                                ></iconify-icon>

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