@extends('modules.layouts.index', ['title' => 'My Project'])

@section('section')
<div class="col-span-9 pl-4 h-full">
    <h3 class="text-lg py-3 border-b-2  font-bold mb-3">My Project</h3>
    <x-e-data-table>
        <x-slot:buttons>
            <x-button 
                size="sm"
                text="Buat Project" 
                icon="ri-add-line"
                id="createProject"
                type="button"
            />
        </x-slot:buttons>
        <x-slot:thead>
            <tr>
                <th scope="col" class="px-6 py-3">Nama Project</th>
                <th scope="col" class="px-6 py-3">Domain</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </x-slot>
        <x-slot:tbody>
            @foreach($projects as $key => $value)
                <tr>
                    <td scope="col" class="px-6 py-4">{{ $value->name }}</td>
                    <td scope="col" class="px-6 py-4">
                        {{ $value->theme('name') }}
                    </td>
                    <td scope="col" class="px-6 py-4">
                        <div class="flex items-center">
                            @if($value->is_publish == 1)
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Publis
                            @else
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> No Publish
                            @endif
                        </div>
                    </td>
                    <td scope="col" class="px-6 py-4">
                        <a href="{{ route('user.my-project.workspace', ['uuid' => $value->uuid]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-e-data-table>
</div>

<div id="modalTheme" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[70] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Pilih Tema
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalTheme">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 h-max">
                <div id="content-theme" class="min-h-[300px] max-h-[510px] overflow-y-auto overflow-x-hidden"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const $targetEl = document.getElementById('modalTheme');

        const options = {
            backdrop: 'dynamic',
            backdropClasses:
                'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
            onHide: () => {
                console.log('modal is hidden');
            },
            onShow: () => {
                console.log('modal is shown');
            },
            onToggle: () => {
                console.log('modal has been toggled');
            },
        };

        modal = new Modal($targetEl, options);

        $('#createProject').click(function() {
           getContentTheme().then(response => {
                $('#content-theme').html(response);
                modal.show();
           })
        })
    })

    function getContentTheme() {
        return new Promise((resolve, reject) => {
            $.get('{{ url("user/my-project/content-theme") }}')
            .done(response => {
                resolve(response);
            })
            .fail(err => {
                reject(err);
            })
        })
    }
</script>
@endsection