@extends('modules.layouts.index', ['title' => 'Dasboard'])

@section('section')
<div class="col-span-9 pl-4 h-full">
    <h3 class="text-lg py-3 border-b-2  font-bold mb-3">Dashboard</h3>
    <div class="w-full py-4 rounded-lg">
        <div class="w-full flex justify-start items-center flex-grow flex-wrap">
            @foreach($themes->getThemes()->get() as $key => $value)
                <div class="min-w-[25%] h-[200px] p-2">
                    <div 
                        style="background-image: url('{{ url("themes/images/{$value['config']->name}/{$value['config']->thumbnail}") }}')" 
                        class="w-full flex justify-center overflow-hidden items-center relative h-full bg-cover bg-center rounded-lg group bg-slate-100"
                    >
                        <div class="absolute bg-black bg-opacity-40 group-hover:bottom-0 transition-all -bottom-[100%] w-full h-full flex justify-center items-center">
                            <button 
                                type="button"
                                class="text-white px-3 hover:bg-blue-400 active:bg-blue-500 py-1 bg-blue-500 rounded-full shadow-md text-xs"
                            >Buat Project</button>
                        </div>
                    </div>
                    <span class="font-semibold text-sm block mt-2">{{ $value['config']->name }}</span>
                    <span class="font-light text-xs block mt-2">Version : {{ $value['config']->version }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection