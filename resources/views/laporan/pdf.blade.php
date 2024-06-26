<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('css')
        <style>
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
                font-family: 'Tinos', serif;
                font: 12pt;
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            p, table, ol{
                font-size: 9pt;
            }

            @page {
                margin: 0;  /* Ini akan diterapkan ke setiap halaman */
                size: landscape;
            }

            @page :first {
                margin-top: 10mm;  /* Hanya diterapkan ke halaman pertama */
            }

            @media print {
                /* Sembunyikan thead di semua halaman */
                thead {
                    display: table-header-group;
                }

                thead.no-print {
                    display: none;
                }

                @page {
                    /* Hanya tampilkan thead di halaman pertama */
                    margin-top: 0;
                }

                @page :not(:first) {
                    margin-top: 0;
                }
                /* html, body {
                    width: 210mm;
                    height: 297mm;
                } */
                .no-print, .no-print *
                {
                    display: none !important;
                }
            /* ... the rest of the rules ... */
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Content -->
            <main>
                <div class="flex  items-center">
                    <div class="align-items-start">
                        <img src="{{ asset('images/bag-1.jpg') }}" alt="" class="w-1/2 mx-auto" >
                    </div>
                    <div class=" w-full">
                        <div class="text-center font-bold text-lg p-5 flex items-center content-center">
                            <div>
                                <h4>DINAS KESEHATAN </h4>
                                <h5>UPT PUSKESMAS ARJASA</h5>
                                <h5>Alamat: jl raya Banyuwangi desa lamongan kecamatan arjasa kabupaten situbondo, Situbondo 68312</h5>
                                <hr class="border-black px-5 mx-auto">

                                <h5>LAPORAN PEMINJAMAN dan PENGEMBALIAN REKAM MEDIS</h5>
                            </div>
                        </div>
                    </div>
                    <div class="align-items-end">
                        <img src="{{ asset('images/bag-2.jpg') }}" alt="" class="w-1/5" >
                    </div>
                </div>
                <div class="flex justify-center">
                    <button onclick="history.back()" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 no-print"><i class="ti-angle-left btn-icon-prepend"></i> Kembali</button>
                </div>
                <div class="relative  p-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">No RM </th>
                                <th scope="col" class="px-4 py-3">Nama Peminjam</th>
                                <th scope="col" class="px-4 py-3">Tanggal Peminjaman</th>
                                <th scope="col" class="px-4 py-3">Tanggal Tenggat</th>
                                <th scope="col" class="px-4 py-3">Status Peminjaman</th>
                                <th scope="col" class="px-4 py-3">Unit</th>
                                <th scope="col" class="px-4 py-3">Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ ucwords($item->pasien->no_rm) }}</th>
                                    <td class="px-4 py-3">{{ $item->user != null ? $item->user->name : "-" }}</td>

                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->translatedFormat('d F Y') }}</td>
                                    <td class="px-4 py-3">{{ $item->tanggal_pengembalian != null ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->translatedFormat('d F Y') : '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->status_rm == 'pending')
                                            @if (Auth::user()->role == 'petugas-rm')
                                                <span class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 verifikasi-modal">Verifikasi RM</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Verifikasi RM</span>
                                            @endif
                                            {{-- jika rawat inap set tangggal pulang  --}}
                                        @else
                                            @if ($item->unit_default == 'rawat-inap')
                                                @if ($item->tanggal_pengembalian == null)
                                                    <span class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 settanggal-modal">Set Tanggal Pulang</span>
                                                @else
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucwords($item->status_rm) }}</span>
                                                @endif
                                            @else
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucwords($item->status_rm) }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->unit_default != null ? $item->unit_default : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ ucwords($item->keperluan) }}
                                    </td>

                                </tr>
                            @empty

                            @endforelse

                        </tbody>
                    </table>
                    <div class="content-ttd my-4">
                        <div class="flex justify-end">
                            <div class="">
                                <p class="text-center p-0">Situbondo, {{ \Carbon\Carbon::parse(now())->translatedFormat('d F Y') }} </p>
                                <div class="kolom-ttd">
                                    <h4 class="fw-bold text-center p-0" style="font-size: 14px;">KEPALA &nbsp;</h4>
                                    <h4 class="fw-bold text-center" style="font-size: 14px;">DINAS KESEHATAN PUSKESMAS ARJASA <br> Kab. Situbondo ,</h4>
                                    <div class="py-4"></div>
                                    <h4 class="fw-bold text-center " style="font-size: 14px;">
                                        <u>(&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</u>
                                    </h4>
                                    <h4 class="fw-bold text-center" style="font-size: 14px;">{{ ucwords($ttd->nama) }}</h4>
                                    <h4 class="fw-bold px-4" style="font-size: 14px;">NIP. {{ $ttd->nip }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
    <script>
        print();
    </script>
</html>
