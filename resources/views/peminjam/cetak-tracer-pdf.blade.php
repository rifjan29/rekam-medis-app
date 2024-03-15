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
        <div class="p-4">
            <div class="mt-20 p-4">
                <div class="mx-auto max-w-full h-full">
                    <!-- Start coding here -->
                    <div class="bg-white border dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible h-full z-0">
                        <div class="pt-5">
                        <h4 class="text-center font-bold text-lg">TRACER</h4>
                        <h4 class="text-center font-bold text-lg">PUSKESMAS ARJASA KABUPATEN SITUBONDO</h4>
                        </div>
                        <hr class="mt-3">

                        <div class="p-10">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="p-10">
                                        <td width="20%" class="py-3">NOMOR RM</td>
                                        <td width="1%">:</td>
                                        <td >{{ ucwords($data->pasien->no_rm) }}</td>
                                    </tr>
                                    <tr class="p-10">
                                        <td width="20%" class="py-3">NAMA</td>
                                        <td width="1%">:</td>
                                        <td >{{ ucwords($data->pasien->nama_pasien) }}</td>
                                    </tr>
                                    <tr class="p-10">
                                        <td width="20%" class="py-3">TANGGAL LAHIR</td>
                                        <td width="1%">:</td>
                                        <td >{{ Carbon\Carbon::parse($data->pasien->tanggal_lahir)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr class="p-10">
                                        <td width="20%" class="py-3">UNIT</td>
                                        <td width="1%">:</td>
                                        <td >{{ ucwords(str_replace('-',' ', $data->unit)) }}</td>
                                    </tr>
                                    <tr class="p-10">
                                        <td width="20%" class="py-3">TANGGAL PINJAM</td>
                                        <td width="1%">:</td>
                                        <td >{{ Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d-m-Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
    <script>
        print();
    </script>
</html>
