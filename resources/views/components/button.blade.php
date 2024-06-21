@isset($size)
    @if($size === 'sm')
        @if($type === 'link')
            <a 
                {{ $attributes }}
                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                @isset($icon)
                    <i class="{{ $icon }}"></i>
                @endisset
                {{ $text }}
            </a>
        @else
            <button 
                {{ $attributes }}
                type="button" 
                class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            {{ $text }}
            </button>
        @endif
    @elseif($size === 'md')
        @if($type === 'link')
            <a 
                {{ $attributes }}
                class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                @isset($icon)
                    <i class="{{ $icon }}"></i>
                @endisset
                {{ $text }}
            </a>
        @else
            <button 
                {{ $attributes }}
                type="button" 
                class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            {{ $text }}
            </button>
        @endif
    @elseif($size === 'lg')
        @if($type === 'link')
            <a 
                {{ $attributes }}
                class="px-3 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                @isset($icon)
                    <i class="{{ $icon }}"></i>
                @endisset
                {{ $text }}
            </a>
        @else
            <button 
                {{ $attributes }}
                type="button" 
                class="px-3 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            {{ $text }}
            </button>
        @endif
    @endif
@endisset