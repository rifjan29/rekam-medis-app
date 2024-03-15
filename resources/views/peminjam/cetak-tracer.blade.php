<x-app-layout>

    <div class="p-4 sm:ml-64">
        <div class="mt-20 p-4">
            <div class="mx-auto max-w-full h-full">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible h-full z-0">
                    <div class="pt-5">
                    <h4 class="text-center font-bold text-lg">TRACER</h4>
                    <h4 class="text-center font-bold text-lg">PUSKESMAS ARJASA KABUPATEN SITUBONDO</h4>
                    </div>
                    <hr class="mt-3">
                    <div class="flex justify-end p-4">
                        <a href="{{ route('peminjaman.tracer-pdf',$data->id) }}" class="flex items-center justify-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 ">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Cetak Tracer
                        </a>
                    </div>
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
</x-app-layout>
