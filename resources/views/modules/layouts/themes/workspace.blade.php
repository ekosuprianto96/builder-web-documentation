<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ? $title : 'CRUD Documentation' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- Remix icon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
    <script src="https://unpkg.com/grapesjs"></script>

    <style>
      /* We can remove the border we've set at the beginning */
      /* :root {
      --gjs-primary-color: #4e4e4e;
      --gjs-secondary-color: rgb(255, 255, 255);
      --gjs-tertiary-color: #393939;
      --gjs-quaternary-color: #414141;
      } */

      .gjs-block .gjs-one-bg {
        height: 10px;
      }
  </style>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <script src="{{ asset('vendor/js/tw-grapsjs.js') }}"></script>

</head>
<body>

    @yield('section')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
</body>
</html>