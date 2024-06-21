<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    {{-- font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    {{-- Remix icon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/jquery-state-store@1.4.5/dist/jquery-state-store.min.js"></script>

    <title>{{ $title ? $title : 'Eko' }}</title>

    <style>
        * {
            font-family: "Poppins", sans-serif;
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>

    @include('modules.frontend.components.header')

    <main class="min-w-screen sm:px-40 min-h-screen max-h-max border">
        <div class="w-full h-full mt-8">
            <div class="grid grid-cols-12 gap-6 w-full h-[1000px]">

                @include('modules.frontend.components.sidebar')
                
                @yield('section')
            </div>
        </div>
    </main>

</body>
</html>