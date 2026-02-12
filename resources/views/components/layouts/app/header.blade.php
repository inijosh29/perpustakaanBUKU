<header
    class="sticky top-0 z-40 w-full border-b border-slate-100 bg-white/90 backdrop-blur-md dark:bg-gray-800 dark:border-gray-700">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- LEFT: LOGO & NAV --}}
        <div class="flex items-center gap-10">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" wire:navigate>
                <x-app-logo class="w-10 h-10 text-emerald-600 transition-transform group-hover:scale-110" />
                <div class="flex flex-col leading-none">
                    <span class="text-xl font-black tracking-tight text-slate-800 dark:text-white">
                        Pin<span class="text-emerald-500">Book</span>
                    </span>
                    <span class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-400">
                        Management System
                    </span>
                </div>
            </a>

            <nav class="hidden md:flex">
                <flux:navlist class="flex flex-row items-center gap-1">
                    <flux:navlist.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        Dashboard
                    </flux:navlist.item>

                    <flux:navlist.item icon="document-text" href="{{ url('/books') }}"
                        :current="request()->is('books*')" wire:navigate>
                        Books
                    </flux:navlist.item>

                    <flux:navlist.item icon="clipboard-document-list" href="{{ url('/rentals') }}"
                        :current="request()->is('rentals*')" wire:navigate>
                        Pinjam Buku
                    </flux:navlist.item>

                    {{-- ADMIN: APPROVE RENTALS --}}
                    @if (auth()->user()->role === 'admin')
                        <flux:navlist.item icon="check-circle" :href="route('admin.rentals')"
                            :current="request()->is('admin/rentals*')" wire:navigate
                            class="!text-emerald-600 font-bold">
                            Approve Pinjam
                        </flux:navlist.item>
                    @endif
                </flux:navlist>
            </nav>
        </div>

        {{-- RIGHT: NOTIF & PROFILE --}}
        <div class="flex items-center gap-4">

            {{-- NOTIFICATIONS --}}
            @if (auth()->user()->role === 'user')
                <div class="flex items-center">
                    {{-- Ganti bagian button notification di header menjadi ini --}}
                    <button x-data @click="$dispatch('open-drawer')" type="button"
                        class="group relative p-2 text-slate-500 hover:text-emerald-600 transition-all rounded-full hover:bg-emerald-50 dark:hover:bg-gray-800 focus:outline-none">

                        <flux:icon.bell class="w-6 h-6 transition-transform group-hover:rotate-12" />

                        <div class="absolute -top-0.5 -right-0.5">
                            <livewire:notification.badge />
                        </div>
                    </button>

                    {{-- Komponen Drawer (Hidden by default) --}}
                    <livewire:notification.index />
                </div>
            @endif

            {{-- Separator tipis --}}
            <div class="h-6 w-[1px] bg-slate-200 dark:bg-gray-700"></div>

            {{-- PROFILE DROPDOWN --}}
            <flux:dropdown position="bottom" align="end">
                {{-- Trigger --}}
                <div
                    class="flex items-center gap-3 px-3 py-1.5 rounded-full border border-slate-200 dark:border-gray-700 hover:border-emerald-400 cursor-pointer bg-white dark:bg-gray-900 shadow-sm transition-all active:scale-95">
                    <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                        icon:trailing="chevrons-up-down" />
                </div>

                {{-- Menu Items --}}
                <flux:menu class="w-[220px] shadow-xl border border-slate-200/50">
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        Settings
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full text-left font-bold text-red-600 hover:!text-red-700 hover:!bg-red-50 dark:hover:!bg-red-950/20">
                            Log Out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>

    </div>
</header>
