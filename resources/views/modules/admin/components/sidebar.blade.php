<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-72 p-2 h-screen pt-20 lg:pt-16 transition-transform -translate-x-full lg:bg-white sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-slate-100 py-4 rounded-lg dark:bg-gray-800">
        {{-- @dd((request()->route()->getName() === 'admin.module')) --}}
        <ul class="space-y-2 font-medium">
            @foreach($modules as $key => $value)
                @if($value->menus->count() <= 1)
                    <li>
                        <a href="{{ url($value->menus->first()->url) }}" class="flex items-center p-2 text-gray-900 {{ isActive($role.'.'.str_replace(' ', '-', strtolower($value->name))) }} rounded-lg dark:text-white hover:bg-slate-200 dark:hover:bg-gray-700 group">
                            <i class="{{ $value->iconMenu->value }} pl-2"></i>
                            <span class="ms-3">{{ $value->name }}</span>
                        </a>
                    </li>
                @else
                    <li>
                        <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-slate-200 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                            <i class="{{ $value->iconMenu->value }}"></i>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $value->name }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-example" class="hidden py-2 space-y-2">
                            @foreach($value->menus as $key => $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-slate-200 dark:text-white dark:hover:bg-gray-700">{{ $menu->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>