<div class="w-full flex justify-start items-center flex-grow flex-wrap">
    @foreach($themes as $key => $value)
        <div class="min-w-[20%] p-2">
            <div 
                style="background-image: url('{{ url("themes/images/{$value['config']->name}/{$value['config']->thumbnail}") }}')" 
                class="w-full h-[200px] flex justify-center overflow-hidden items-center relative bg-cover bg-center rounded-lg group bg-slate-100"
            >
                <div class="absolute flex-col gap-3 bg-black bg-opacity-40 group-hover:bottom-0 transition-all -bottom-[100%] w-full h-full flex justify-center items-center">
                    <a
                        href="{{ route('theme.preview', $value['config']->id) }}"
                        class="text-white px-3 hover:bg-blue-400 active:bg-blue-500 py-1 bg-blue-500 rounded-full shadow-md text-xs"
                    >
                        <i class="ri-eye-line"></i> Preview
                    </a>
                    <a
                        href="{{ url('user/my-project/create?theme='.$value['config']->id) }}"
                        class="text-white px-3 hover:bg-blue-400 active:bg-blue-500 py-1 bg-blue-500 rounded-full shadow-md text-xs"
                    >
                        <i class="ri-add-line"></i> Buat Project
                    </a>
                </div>
            </div>
            <span class="font-semibold text-sm block mt-2">{{ $value['config']->name }}</span>
            <span class="font-light text-xs block mt-2">Version : {{ $value['config']->version }}</span>
        </div>
    @endforeach
</div>