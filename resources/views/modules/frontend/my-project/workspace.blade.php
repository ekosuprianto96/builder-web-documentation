@extends('modules.layouts.themes.workspace', ['title' => $project->name])

@section('section')
<div class="col-span-9 h-full">
    <div class="w-full grid grid-cols-12 min-h-[100vh]">
        <div class="col-span-2 bg-[#444444]">
            <div class="px-3 py-2 border-b border-b-zinc-800 flex justify-between items-center">
                <span class="text-slate-50"><i class="ri-pages-line"></i> Pages</span>
                <button id="addPage" title="Create New Page" class="w-[30px] h-[30px] bg-slate-50 hover:bg-opacity-10 rounded-lg bg-opacity-30">
                    <i class="ri-add-line text-slate-50"></i>
                </button>
            </div>
            <div class="border-b py-3">
                <ul class="px-2" id="wrapperPages">
                    
                </ul>
            </div>
        </div>
        <div style="display: none" class="col-span-10" id="container-editor">
            
        </div>

        <div class="col-span-10 h-full animate-pulse bg-slate-200 rounded-lg" id="container-skeleton">
            
        </div>
    </div>

    {{-- Modal Add Page --}}
    <div id="modal-add-page" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Page
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-add-page">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" id="formAddPage" action="#">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required />
                        </div>
                        <x-button 
                            size="sm"
                            text="Simpan Page" 
                            icon="''"
                            id="savePage" 
                            type="button"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Select Page --}}
    <div id="modal-select-page" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Pilih Target Menu
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-select-page">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" id="formSelectPage" action="#">
                        <div>
                            <label for="selectPage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Halaman Target</label>
                            <select id="selectPage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option>-- Halaman Target --</option>
                            </select>
                        </div>
                        <x-button 
                            size="sm"
                            text="Simpan" 
                            icon="''"
                            id="saveTargetHalaman" 
                            type="button"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        
    </script>
    <script>
        isDirty = false;
        const escapeName = (name) => `${name}`.trim().replace('/([^a-z0-9\w-:/]+)/gi', '-');
        const $targetEl = document.getElementById('modal-add-page');
        let currentComponent = null;
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
        const $selectPage = document.getElementById('modal-select-page');
        const optionsModalSelect = {
            backdrop: 'dynamic',
            backdropClasses:
                'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
        };

        $modal = new Modal($targetEl, options);
        $modalSelect = new Modal($selectPage, optionsModalSelect);

        const editor = grapesjs.init({
            container: '#container-editor',
            height: '100%',
            storageManager: false,
            selectorManager: { escapeName },
            plugins: ['grapesjs-tailwind'],
            pluginsOpts: {
                'grapesjs-tailwind': {
                    apiUrl: '{{ route("user.web-base.theme.blocks", $theme['id']) }}',
                    apiUrlPages: '{{ route("user.web-base.theme.pages", $project->uuid) }}',
                    urlStore: '{{ route("user.web-base.theme.pages.store", $project->uuid) }}',
                    urlDestroyPage: '{{ route("user.web-base.theme.pages.destroy", $project->uuid) }}',
                    urlUpdateNamePage: '{{ route("user.web-base.theme.pages.update-name", $project->uuid) }}',
                    urlSaveProjects: '{{ route("user.web-base.theme.pages.save-projects", $project->uuid) }}',
                    csrfToken: '{{ csrf_token() }}'
                }
            }
        });

        $('#savePage').click(function() {
            const pages = editor.Pages;
            $.storePage({
                title: $('#title').val(),
                _token: '{{ csrf_token() }}'
            }).then(response => {
                if(response.status) {
                    pages.add({
                        id: response.detail.id,
                        name: response.detail.title,
                        style: response.detail.style,
                        component: response.detail.content
                    });
                    const $pg = editor.Pages;
                    const getPage = $pg.get(parseInt(response.detail.id));
                    $pg.select(getPage);
                    editor.runCommand('get-pages');
                    return
                }
            }).finally(() => {
                $modal.hide();
                $('#formAddPage')[0].reset();
            })
        });

        $('.btn-save').click(function() {
            editor.runCommand('save-project', {
                success: (response) => {
                    isDirty = false;
                    console.log(response);
                },
                error: (error) => {
                    console.log(error);
                }
            })
        })

        // Set isDirty menjadi true setiap kali ada perubahan di editor
        editor.on('change', () => {
            isDirty = true;
        });

        // Tambahkan event listener sebelum halaman ditutup
        window.addEventListener('beforeunload', function (e) {
            if (isDirty) {
                const confirmationMessage = 'Perubahan Anda belum disimpan. Apakah Anda yakin ingin meninggalkan halaman ini?';
                e.returnValue = confirmationMessage; // Standar
                return confirmationMessage;          // Beberapa browser
            }
        });

        editor.on('component:selected', model => {
            if (model.is('menu-link')) {
                let optionsSelect = '<option>-- Halaman Target --</option>';
                $('#selectPage').html(optionsSelect)
                const pages = editor.Pages.getAll();
                currentComponent = model;
                
                if(pages.length > 0) {
                    pages.map(page => {
                        if(page.attributes.name !== '') {
                            console.log(page.attributes?.name.toLowerCase().replace(' ', '-'), model.get('attributes').href)
                            optionsSelect += `<option ${(page.attributes?.name.toLowerCase().replace(' ', '-')+'.html' === model.get('attributes').href ? 'selected' : '')} value="${page.attributes?.name.toLowerCase().replace(' ', '-')}.html">${page.attributes.name}</option>`;
                        }
                    })

                    $('#selectPage').html(optionsSelect);
                }
                $modalSelect.show();

            }
        });

        $('#saveTargetHalaman').click(function() {
            if($('#selectPage').val() !== '') {
                currentComponent.addAttributes({ href: $('#selectPage').val() });
                $('#selectPage').val('')
                $modalSelect.hide();
            }
        })

        editor.Commands.add('show-add-page-modal', {
            run(editor, opts) {
                $modal.show()
            }
        });

        editor.on('page:add', function(page) {

        })

        $(document).ready(function() {
            
            $('#container-skeleton').hide();
            $('#container-editor').show();


            $('#addPage').click(function() {
                editor.runCommand('show-add-page-modal');
            });

        })

    </script>
</div>
@endsection