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
