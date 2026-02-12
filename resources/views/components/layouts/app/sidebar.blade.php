<flux:sidebar sticky stashable class="bg-green-100 dark:bg-gray-800">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo />
    </a>

    <flux:navlist>
        <flux:navlist.group :heading="__('Platform')" class="grid">

            <flux:navlist.item
                icon="home"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Dashboard
            </flux:navlist.item>

            <flux:navlist.item
                icon="document-text"
                href="{{ url('/books') }}"
                :current="request()->is('books*')"
                wire:navigate
            >
                Books
            </flux:navlist.item>

            <flux:navlist.item
                icon="clipboard-document-list"
                href="{{ url('/rentals') }}"
                :current="request()->is('rentals*')"
                wire:navigate
            >
                Rental Buku
            </flux:navlist.item>

            {{-- 🔔 NOTIFICATION --}}
            <flux:navlist.item
                icon="bell"
                :href="route('notifications.index')"
                :current="request()->routeIs('notifications.index')"
                wire:navigate
                class="relative"
            >
                Notifications

                {{-- Badge Livewire --}}
                <livewire:notification.badge />
            </flux:navlist.item>

            @if(auth()->user()->role === 'admin')
                <flux:navlist.item
                    icon="check-circle"
                    :href="route('admin.rentals')"
                    :current="request()->is('admin/rentals*')"
                    wire:navigate
                >
                    Approve Rentals
                </flux:navlist.item>
            @endif

        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    {{-- PROFILE DESKTOP --}}
    <flux:dropdown class="hidden lg:block" position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon:trailing="chevrons-up-down"
        />
        <flux:menu class="w-[220px]">
            <div class="p-2 text-sm font-semibold">{{ auth()->user()->name }}</div>

            <flux:menu.separator />

            <flux:menu.item
                :href="route('profile.edit')"
                icon="cog"
                wire:navigate
            >
                Settings
            </flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full text-left"
                >
                    Log Out
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

{{-- MOBILE HEADER --}}
<flux:header class="lg:hidden">
    <flux:sidebar.toggle icon="bars-2" inset="left" />
    <flux:spacer />

    <flux:dropdown position="top" align="end">
        <flux:profile
            :initials="auth()->user()->initials()"
            icon-trailing="chevron-down"
        />
        <flux:menu>

            <flux:menu.item
                :href="route('notifications.index')"
                icon="bell"
                wire:navigate
            >
                Notifications
            </flux:menu.item>

            <flux:menu.item
                :href="route('profile.edit')"
                icon="cog"
                wire:navigate
            >
                Settings
            </flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                >
                    Log Out
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>
