<x-layouts.auth>
    <div class="bg-white rounded-3xl shadow-2xl p-8">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-600">
                Create Account
            </h1>
            <p class="text-sm text-gray-500">
                Isi data untuk membuat akun
            </p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <flux:input
                name="name"
                label="Name"
                required
                placeholder="Full name"
                class="bg-white text-gray-700 border border-gray-300
                       focus:border-emerald-500 focus:ring-0"
            />

            <flux:input
                name="email"
                label="Email address"
                type="email"
                required
                placeholder="email@example.com"
                class="bg-white text-gray-700 border border-gray-300
                       focus:border-emerald-500 focus:ring-0"
            />

            <flux:input
                name="password"
                label="Password"
                type="password"
                required
                viewable
                class="bg-white text-gray-700 border border-gray-300
                       focus:border-emerald-500 focus:ring-0"
            />

            <flux:input
                name="password_confirmation"
                label="Confirm password"
                type="password"
                required
                viewable
                class="bg-white text-gray-700 border border-gray-300
                       focus:border-emerald-500 focus:ring-0"
            />

            <flux:button
                type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl"
            >
                Create account
            </flux:button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            Already have an account?
            <flux:link
                :href="route('login')"
                class="text-emerald-600 font-semibold hover:underline"
                wire:navigate
            >
                Log in
            </flux:link>
        </div>
    </div>
</x-layouts.auth>
