<x-app-layout>
    @push('js')
        <script>
            $('#kategori').on('change',function() {
                $('#form').submit();
            })
        </script>
    @endpush
    <div class="p-4 sm:ml-64">
        <div class="flex justify-between mt-20 p-4">
            <div>
                <h5 class="font-bold text-lg dark:text-white">{{ $title }}</h5>
            </div>
            <div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                            Dashboard
                        </a>
                    </li>

                    <li aria-current="page">
                        <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ ucwords($title) }}</span>
                        </div>
                    </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="p-4">
            <div class="mx-auto max-w-full h-full">
                <!-- Start coding here -->
                <div class="card bg-white p-5 mt-4 border rounded-md w-full relative overflow-x-auto space-y-4 mb-5">
                    <div class="card bg-white p-5 mt-4 border rounded-md w-full relative overflow-x-auto">
                        <form action="{{ route('laporan.search') }}">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <x-label-default for="" value="Tanggal Kunjungan">Tanggal Filter</x-label-default>
                                    <div date-rangepicker class="flex items-center w-full">
                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            <input name="start" value="{{ request('start') }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                                        </div>
                                        <span class="mx-4 text-gray-500">to</span>
                                        <div class="relative w-full">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            <input name="end" value="{{ request('end') }}" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex align-bottom content-end items-end">
                                    <div>
                                        <x-primary-button type="submit">Filter</x-primary-button>
                                    </div>
                                    <div class="mx-3">
                                        <a href="{{ route('laporan.export',request()->all()) }}" class="flex items-center justify-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 ">
                                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                            </svg>
                                            Export
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible h-full z-0">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center gap-3" action="{{ route('laporan.search') }}" id="form" method="GET">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" >
                                </div>
                                <select name="kategori" id="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="0">Pilih Status</option>
                                    <option value="terlambat">Terlambat</option>
                                    <option value="sukses">Tidak Terlambat</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </form>
                        </div>
                        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">


                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th scope="col" class="px-4 py-3">No RM </th>
                                    <th scope="col" class="px-4 py-3">Nama Peminjam</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Peminjaman</th>
                                    <th scope="col" class="px-4 py-3">Total Hari</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Tenggat</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Pengembalian</th>
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
                                        <td class="px-4 py-3">
                                            @php
                                                $toDate = \Carbon\Carbon::parse($item->tanggal_peminjaman);
                                                $endDate = \Carbon\Carbon::parse($item->tanggal_pengembalian != null ? \Carbon\Carbon::parse($item->tanggal_pengembalian) : \Carbon\Carbon::now());
                                                $total = $toDate->diffInDays($endDate);
                                            @endphp
                                            {{ $total }}
                                        </td>
                                        <td class="px-4 py-3">{{ $item->tanggal_pengembalian != null ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->translatedFormat('d F Y') : '-' }}</td>
                                        <td class="px-4 py-3">{{ $item->verifikasi_tanggal != null ? \Carbon\Carbon::parse($item->verifikasi_tanggal)->translatedFormat('d F Y') : '-' }}</td>
                                        <td class="px-4 py-3">
                                            @if ($item->status_rm == 'pending')
                                                @if (Auth::user()->role == 'petugas-rm')
                                                    <span class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 verifikasi-modal">Verifikasi RM</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Verifikasi RM</span>
                                                @endif
                                                {{-- jika rawat inap set tangggal pulang  --}}
                                            @else
                                                @if ($item->unit_default == 'ugd')
                                                    @if ($item->unit_default == 'rawat-inap')
                                                        @if ($item->tanggal_pengembalian == null)
                                                            <span class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 settanggal-modal">Set Tanggal Pulang</span>
                                                        @else
                                                            @if ($item->status_pengembalian == 'sukses')
                                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Tepat</span>
                                                            @else
                                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Telat</span>
                                                            @endif

                                                        @endif
                                                    @else
                                                        @if ($item->status_pengembalian == 'sukses')
                                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Tepat</span>
                                                        @else
                                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Telat</span>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($item->status_pengembalian == 'sukses')
                                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Tepat</span>
                                                    @else
                                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Telat</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ ucwords($item->unit_default) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ ucwords($item->keperluan) }}
                                        </td>

                                    </tr>
                                @empty

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col md:flex-row justify-end items-start md:items-center space-y-3 md:space-y-5 p-4" aria-label="Table navigation">

                        {{ $data->links() }}
                    </nav>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
