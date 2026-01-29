<x-layouts.auth>
    <div class="bg-white rounded-3xl shadow-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-600">
                Welcome Back
            </h1>
            <p class="text-sm text-gray-500">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- Status -->
        <x-auth-session-status
            class="mb-4 text-center text-sm text-red-500"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <flux:input
                name="email"
                label="Email address"
                type="email"
                required
                autofocus
                placeholder="email@gmail.com"
                class="bg-white text-gray-700 border border-gray-300
                       focus:border-emerald-500 focus:ring-0"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    label="Password"
                    type="password"
                    required
                    placeholder="Password"
                    viewable
                    class="bg-white text-gray-700 border border-gray-300
                           focus:border-emerald-500 focus:ring-0"
                />

                <flux:link
                    class="absolute top-0 right-0 text-sm text-emerald-600 hover:underline"
                    :href="route('password.request')"
                    wire:navigate
                >
                    Forgot password?
                </flux:link>
            </div>

            <flux:checkbox
                name="remember"
                label="Remember me"
                class="text-gray-600"
            />

            <flux:button
                type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl"
            >
                Log in
            </flux:button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun?
            <flux:link
                :href="route('register')"
                class="text-emerald-600 font-semibold hover:underline"
                wire:navigate
            >
                Daftarr
            </flux:link>
        </div>
    </div>
</x-layouts.auth>
