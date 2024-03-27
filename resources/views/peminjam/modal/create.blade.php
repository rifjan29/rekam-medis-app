<!-- Main modal -->
<div id="tambah-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Peminjaman
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="tambah-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form action="{{ route('peminjaman.store') }}" method="POST" class="w-full mx-auto" >
                    @csrf
                    <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 sm:gap-6 mb-5">
                        <div class="col-span-2 sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No RM </label>
                            <select id="no_rm" name="no_rm" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">Pilih No RM</option>
                                @foreach ($rekam_medis as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_rm }} - {{ $item->nama_pasien }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->role == 'petugas-rm')
                        <div class="col-span-2 sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Peminjam </label>
                            <select id="peminjam" name="peminjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">Pilih Peminjam</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->no_hp }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                            <div class="col-span-2 sm:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Peminjaman</label>
                                <input type="text" name="nama_pinjam" id="nama_pinjam" readonly value="{{ old('nama_pinjam',Auth::user()->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Nama Peminjaman">
                            </div>
                        @endif
                        <div class="col-span-2 sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Peminjaman</label>
                            <input type="text" datepicker  datepicker-format="d-m-yyyy" name="tgl_pinjam" id="tgl_pinjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Tanggal Peminjaman">
                        </div>

                        <div class="col-span-2 sm:col-span-2 hidden">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
                            <select id="unit" name="unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0">Pilih Unit</option>
                                <option value="rawat-inap">Rawat Inap</option>
                                <option value="rawat-jalan">Rawat Jalan</option>
                            </select>
                        </div>
                        @if ($user == 'rawat-inap')
                            <div class="col-span-2 sm:col-span-2" id="kamar">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cara Pembayaran</label>
                                <input type="text" name="kamar" id="kamar" value="{{ old('kamar') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukkan Cara Pembayaran Umum/BPJS">
                            </div>
                        @endif
                        <div class="col-span-2 sm:col-span-2">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keperluan</label>
                            <textarea id="keperluan" rows="4" name="keperluan" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Keperluan..."></textarea>
                        </div>
                    </div>

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
            </form>
                <button data-modal-hide="tambah-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white
                dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>

            </div>
        </div>
    </div>
</div>
