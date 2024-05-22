<x-app-layout>
    @include('users.modal.create')
    @include('users.modal.show')
    @include('users.modal.edit')
    @push('js')
        <script>
            // show
            $('.show-data').on('click',function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `{{ route('user.show', 1) }}`,
                    data: {
                        id: id
                    },
                    method: "GET",
                    success: (res) => {
                        // Assuming you have a modal with an ID 'show-modal'
                        $('#show-modal #name').val(res.name);
                        $('#show-modal #nip').val(res.nip);
                        $('#show-modal #email').val(res.email);
                        $('#show-modal #roles').val(res.role);

                        // Show the modal
                        $('#show-modal').removeClass('hidden');

                    }
                })
            })
            // edit
            $('.edit-data').on('click',function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `{{ route('user.edit', 1) }}`,
                    data: {
                        id: id
                    },
                    method: "GET",
                    success: (res) => {
                        console.log(res);
                        // Assuming you have a modal with an ID 'show-modal'
                        $('#edit-modal #id').val(res.id);
                        $('#edit-modal #name').val(res.name);
                        $('#edit-modal #nip').val(res.nip);
                        $('#edit-modal #email').val(res.email);
                        $('#edit-modal #roles').val(res.role);
                        $('#edit-modal #no_hp').val(res.no_hp);
                        $('#edit-modal #poli').val(res.poli_id);
                        // Add more lines for other attributes

                        // Show the modal
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
                            <form class="flex items-center" action="{{ route('user.search') }}" method="GET">
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
                            <button data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"  class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Tambah User
                            </button>

                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th scope="col" class="px-4 py-3">NIP </th>
                                    <th scope="col" class="px-4 py-3">Nama </th>
                                    <th scope="col" class="px-4 py-3">Username</th>
                                    <th scope="col" class="px-4 py-3">No Hp</th>
                                    <th scope="col" class="px-4 py-3">Roles</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $item->nip != null ? $item->nip : '-' }}</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ ucwords($item->name) }}</th>
                                        <td class="px-4 py-3">{{ $item->email }}</td>
                                        <td class="px-4 py-3">{{ $item->no_hp != null ? $item->no_hp : '-' }}</td>
                                        <td class="px-4 py-3">{{ $item->role }}</td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button id="{{ $item->id }}-button" data-dropdown-toggle="{{ $item->id }}-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="{{ $item->id }}-dropdown" class="hidden z-50 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{ $item->id }}-button">
                                                    <li>
                                                        <a href="#" data-modal-target="show-modal" data-modal-toggle="show-modal" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white show-data" data-id="{{ $item->id }}">Show</a>
                                                    </li>
                                                </ul>
                                                <div class="py-1">
                                                    <a href="{{ route('user.destroy', $item->id) }}" data-confirm-delete="true" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                </div>
                                                @if (Auth::user()->role == 'admin')
                                                    @if (Auth::user()->id != $item->id)
                                                    <a href="#" data-modal-target="edit-modal" data-modal-toggle="edit-modal" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white edit-data" data-id="{{ $item->id }}">Edit</a>
                                                    @endif
                                                @else
                                                    @if (!Auth::user()->id == $item->id)
                                                    <div class="py-1">
                                                        <a href="{{ route('user.destroy', $item->id) }}" data-confirm-delete="true" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
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
