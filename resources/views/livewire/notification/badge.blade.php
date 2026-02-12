<div class="relative inline-flex items-center">
    @if ($count > 0)
        <span
            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-gray-900"
        >
            {{ $count > 9 ? '9+' : $count }}
        </span>
    @endif
</div>