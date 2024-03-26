<td class="px-4 py-3">{{ $loop->iteration }}</td>
<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ ucwords($item->pasien->no_rm) }}</th>
<td class="px-4 py-3">{{ $item->user != null ? $item->user->name : "-" }}</td>
<td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->translatedFormat('d F Y') }}</td>

<td class="px-4 py-3">{{ $item->tanggal_pengembalian != null ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->translatedFormat('d F Y') : '-' }}</td>
<td class="px-4 py-3">{{ $item->verifikasi_tanggal != null ? \Carbon\Carbon::parse($item->verifikasi_tanggal)->translatedFormat('d F Y') : '-' }}</td>
<td class="px-4 py-3">
    @if ($item->status_rm == 'pending')
        @if (Auth::user()->role == 'petugas-rm')
            @if ($item->is_verifikasi == 'petugas-rm')
                <a href="#" data-modal-target="verifikasi-modal" data-modal-toggle="verifikasi-modal" data-id="{{ $item->id }}" class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 verifikasi-modal">Verifikasi RM</a>
            @else
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Verifikasi RM</span>
            @endif
        @else
            @if ($item->is_verifikasi == 'petugas-peminjam')
                <a href="#" data-modal-target="verifikasi-modal" data-modal-toggle="verifikasi-modal" data-id="{{ $item->id }}" class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 verifikasi-modal">Verifikasi RM</a>
            @else
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Verifikasi RM</span>
            @endif
        @endif
        {{-- jika rawat inap set tangggal pulang  --}}
    @else
        @if ($item->unit == 'rawat-inap')
            @if ($item->tanggal_pengembalian == null)
                @if (Auth::user()->role == 'petugas-peminjam')
                    <a href="#" data-modal-target="settanggal-modal" data-modal-toggle="settanggal-modal" data-id="{{ $item->id }}" class="bg-yellow-100 cursor-pointer text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 settanggal-modal">Set Tanggal Pulang</a>
                @else
                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum Set Tanggal Pulang</span>

                @endif
            @else
                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucwords($item->status_rm) }}</span>

            @endif
        @else
            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucwords($item->status_rm) }}</span>

        @endif
    @endif
</td>
<td class="px-4 py-3">
    {{ ucwords(str_replace('-',' ',ucwords($item->unit))) }}
    @if ($item->unit == 'rawat-inap')
        - {{ $item->kamar }}
    @else
        - {{ $item->poli?->poli_name }}
    @endif
</td>
<td class="px-4 py-3">
    {{ ucwords($item->keperluan) }}
</td>
<td class="px-4 py-3 flex items-center justify-end">
    <button id="{{ $item->id }}-button" data-dropdown-toggle="{{ $item->id }}-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
        </svg>
    </button>
    <div id="{{ $item->id }}-dropdown" class="hidden z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{ $item->id }}-button">
            <li>
                <a href="{{ route('peminjaman.destroy', $item->id) }}" data-confirm-delete="true" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
            </li>
            @if (Auth::user()->role == 'petugas-rm' || Auth::user()->role == 'admin')
                @if ($item->status_rm == 'dipinjam')
                    <li>
                        <a href="#" data-modal-target="kembali-modal" data-modal-toggle="kembali-modal" data-id="{{ $item->id }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white kembali-modal">Pengembalian Data</a>
                    </li>
                @endif
                <li>
                    <a href="{{route('peminjaman.tracer',$item->id) }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cetak Tracer</a>
                </li>

            @else

            @endif
        </ul>
    </div>
</td>
