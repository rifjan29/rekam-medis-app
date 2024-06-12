<x-app-layout>
    @include('peminjam.modal.create')
    @include('peminjam.modal.edit')
    @include('peminjam.modal.show')
    @include('peminjam.modal.verifikasi')
    @include('peminjam.modal.kembali')
    @include('peminjam.modal.set')
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0.35rem !important;
                border: 1px solid #d1d3e2;
                height: calc(1.95rem + 10px);
                background: #fff;
                width: 100%
            }

            .select2-container--default .select2-selection--single:hover,
            .select2-container--default .select2-selection--single:focus,
            .select2-container--default .select2-selection--single.active {
                box-shadow: none;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 40px;

            }

            .select2-container--default .select2-selection--multiple {
                border-color: #eaeaea;
                border-radius: 0;
            }

            .select2-dropdown {
                border-radius: 0;
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #3838eb;
            }

            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border-color: #eaeaea;
                background: #fff;

            }
            .select2-container--default .select2-selection--single .select2-selection__arrow{
                top: 5px;
            }
        </style>
    @endpush
    @push('js')

        <script>

            $('.verifikasi-modal').on('click',function() {
                let id = $(this).data('id');
                $('#verifikasi-modal #id').val(id)
                $('#verifikasi-modal').removeClass('hidden');
            })
            $('.kembali-modal').on('click',function() {
                let id = $(this).data('id');
                $('#kembali-modal #id').val(id)
                $('#kembali-modal').removeClass('hidden');
            })
            $('.settanggal-modal').on('click',function(){
                let id = $(this).data('id');
                $(`#settanggal-modal #id`).val(id);
                $(`#settanggal-modal`).removeClass('hidden')
            })
            // edit
            $('.edit-data').on('click',function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `{{ route('peminjaman.edit', 1) }}`,
                    data: {
                        id: id
                    },
                    method: "GET",
                    success: (res) => {
                        console.log(res);
                        // // Assuming you have a modal with an ID 'show-modal'
                        $('#edit-modal #id').val(res.id);
                        $('#edit-modal #no_rm').val(res.id_rm);
                        $('#edit-modal #peminjam').val(res.user_id);
                        $('#edit-modal #nama_pinjam').val(res.user.name);
                        $('#edit-modal #tgl_pinjam').val(res.tanggal_peminjaman);
                        $('#edit-modal #unit').val(res.unit_default);
                        $('#edit-modal #keperluan').val(res.keperluan);
                        var unit_default = res.unit_default;
                        if (unit_default == 'igd') {
                            $('.unit_igd').removeClass('hidden');
                            $('#edit-modal #unit_test').val(res.unit);

                        }else{
                            $('.unit_igd').addClass('hidden');
                            $('#edit-modal #unit_test').val();

                        }

                        // // Show the modal
                        $('#edit-modal').removeClass('hidden');

                    }
                })
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
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-visible h-full z-0">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center" action="{{ route('rekam-medis.search') }}" method="GET">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" >
                                </div>
                            </form>
                        </div>
                        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <button data-modal-target="tambah-modal" data-modal-toggle="tambah-modal" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Tambah Peminjaman
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th scope="col" class="px-4 py-3">No RM </th>
                                    <th scope="col" class="px-4 py-3">Nama Pasien </th>
                                    <th scope="col" class="px-4 py-3">Nama Petugas Peminjaman</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Peminjaman</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Tenggat</th>
                                    <th scope="col" class="px-4 py-3">Tanggal Pengembalian</th>
                                    <th scope="col" class="px-4 py-3">Status Peminjaman</th>
                                    <th scope="col" class="px-4 py-3">Unit</th>
                                    <th scope="col" class="px-4 py-3">Keperluan</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        @if (Auth::user()->role == 'petugas-peminjam')
                                            @if (Auth::user()->id == $item->user_id )
                                                @include('peminjam.__peminjaman-tbody')
                                            @else

                                            @endif

                                        @elseif (Auth::user()->role == 'petugas-rm')
                                            @include('peminjam.__peminjaman-tbody')
                                        @else
                                            @include('peminjam.__peminjaman-admin-tbody')

                                        @endif

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
