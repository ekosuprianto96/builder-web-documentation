<div class="col-span-3 w-full h-full">
    <ul class="w-full sticky top-28 border-r-2 pr-2">
        @foreach($modules as $key => $value)
            @if($value->menus->count() <= 1)
                <li class="mb-2">
                    <a 
                        href="{{ url($value->menus->first()->url) }}" 
                        class="py-3 hover:px-3 transition-all block w-full text-sm rounded-lg hover:bg-slate-200 font-semibold"
                    >
                        <i class="{{ $value->iconMenu->value }} me-2"></i>
                    {{ $value->name }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>