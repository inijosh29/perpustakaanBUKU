<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center
                bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 px-4">

        <div class="w-full max-w-md">
            <!-- Card -->
            <div class="bg-white dark:bg-zinc-900
                        rounded-3xl shadow-2xl p-8 -mt-6">

                <!-- Header -->
                <div class="text-center mb-6">
                    <x-auth-header
                        :title="__('Welcome Back')"
                        :description="__('Please login to continue')"
                    />
                </div>

                <!-- Session Status -->
                <x-auth-session-status
                    class="mb-4 text-center"
                    :status="session('status')"
                />

                <!-- Form -->
                <form method="POST"
                      action="{{ route('login.store') }}"
                      class="flex flex-col gap-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <flux:input
                            name="email"
                            :label="__('Email address')"
                            :value="old('email')"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="email@example.com"
                            class="
                                rounded-2xl
                                bg-zinc-800 text-white
                                border border-zinc-700
                                focus:border-zinc-600
                                focus:ring-0
                                focus:ring-offset-0
                                focus:outline-none
                            "
                        />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                            class="
                                rounded-2xl
                                bg-zinc-800 text-white
                                border border-zinc-700
                                focus:border-zinc-600
                                focus:ring-0
                                focus:ring-offset-0
                                focus:outline-none
                            "
                        />

                        @if (Route::has('password.request'))
                            <flux:link
                                class="absolute top-0 end-0 text-sm
                                       text-indigo-500 hover:text-indigo-400
                                       transition hover:underline"
                                :href="route('password.request')"
                                wire:navigate
                            >
                                {{ __('Forgot password?') }}
                            </flux:link>
                        @endif
                    </div>

                    <!-- Remember -->
                    <div class="transition">
                        <flux:checkbox
                            name="remember"
                            :label="__('Remember me')"
                            :checked="old('remember')"
                            class="
                                cursor-pointer
                                text-zinc-300
                                hover:text-white
                                transition-colors
                                active:scale-[0.98]
                            "
                        />
                    </div>

                    <!-- Submit -->
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="
                            w-full py-3 rounded-2xl font-semibold
                            shadow-lg transition
                            cursor-pointer
                            hover:brightness-110
                            active:scale-[0.97]
                        "
                        data-test="login-button"
                    >
                        {{ __('Log in') }}
                    </flux:button>
                </form>
            </div>

            <!-- Footer -->
            @if (Route::has('register'))
                <div class="mt-6 text-center text-sm text-white/80">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <flux:link
                        :href="route('register')"
                        class="font-semibold text-white underline ml-1
                            hover:text-white/90 transition"
                        wire:navigate
                    >
                        {{ __('Sign up') }}
                    </flux:link>
                </div>
            @endif
        </div>
    </div>
</x-layouts.auth>
