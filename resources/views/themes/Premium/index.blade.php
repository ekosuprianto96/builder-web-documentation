@extends('modules.layouts.themes.index', ['title' => $theme['name']])

@section('section')

    @include('themes/Premium/components/header/navbar', ['title' => $theme['name']])
  
    @include('themes/Premium/components/header/sidebar')
  
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="w-full markdown-content">
                
            </div>
        </div>
    </div>  
@endsection