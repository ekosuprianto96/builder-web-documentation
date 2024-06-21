@extends('modules.layouts.index', ['title' => 'Buat Project'])

@section('section')
<div class="col-span-9 pl-4 h-full">
    <div class=" py-3 flex items-center gap-3 mb-3 border-b-2 justify-between">
        <h3 class="text-lg font-bold">Buat Project</h3>
    </div>
    <div class="mt-4">
        <form class="max-w-full mx-auto" action="{{ route('user.my-project.store') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $theme['id'] }}" name="id_theme">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Proyek</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" 
                    placeholder="Nama projek kamu..." 
                    required 
                />
            </div>
            <div class="mb-5">
                <label for="descriptions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tentang Projek Kamu</label>
                <textarea 
                    required
                    id="descriptions" 
                    name="descriptions"
                    rows="4" 
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="Tulis deskripsi projek kamu..."
                ></textarea>
            </div>
            <button 
                type="submit" 
                id="selanjutnya" 
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >Lanjut</button>
            <a 
                href="{{ url()->previous() ? url()->previous() : route('user.my-project') }}" 
                type="button" 
                id="selanjutnya" 
                class="text-white bg-red-500 hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800"
            >Batal</a>
        </form>
    </div>
</div>
@endsection