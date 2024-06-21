<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ? $title : 'CRUD Documentation' }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet">

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- Remix icon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        * .markdown-content {
            border: none;
        }
        .markdown-content {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .markdown-content h1 {
            font-size: 2em;
            font-weight: bold;
        }
        .markdown-content h2 {
            font-size: 1.8em;
            font-weight: bold;
        }
        .markdown-content h3 {
            font-size: 1.5em;
            font-weight: bold;
        }
        .markdown-content h4 {
            font-size: 1.3em;
            font-weight: bold;
        }
        .markdown-content h1, .markdown-content h2, .markdown-content h3, .markdown-content h4, .markdown-content h5, .markdown-content h6 {
            color: #333;
        }
        .markdown-content p {
            margin: 10px 0;
        }
        .markdown-content ul {
            padding-left: 20px;
            list-style: disc;
        }
        .markdown-content ol {
            padding-left: 20px;
            list-style: decimal;
        }
        .markdown-content pre {
            position: relative;
        }
        .markdown-content pre .copy-button {
            position: absolute;
            right: 10px;
            top: 10px;
            color: rgb(165, 165, 165);
        }
        .markdown-content .copy-button:hover {
            color: rgb(53, 53, 53);
        }
    </style>
</head>
<body>

    @yield('section')
    
    <!-- Prism.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-javascript.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre').forEach((pre) => {
                const button = document.createElement('button');
                button.className = 'copy-button';
                button.innerHTML = '<i class="ri-file-copy-fill"></i>';
                pre.appendChild(button);
                
                button.addEventListener('click', () => {
                    const code = pre.querySelector('code').innerText;
                    navigator.clipboard.writeText(code).then(() => {
                        button.innerText = 'Copied!';
                        setTimeout(() => {
                            button.innerHTML = '<i class="ri-file-copy-fill"></i>';
                        }, 2000);
                    }).catch((err) => {
                        console.error('Failed to copy: ', err);
                    });
                });
            });
        });
    </script>
</body>
</html>