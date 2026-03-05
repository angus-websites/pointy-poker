<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            @php

                $appliedRules = \Illuminate\Validation\Rules\Password::default()->appliedRules();
            @endphp

            <flux:accordion transition>
                <flux:accordion.item>
                    <flux:accordion.heading>View Password Requirements</flux:accordion.heading>
                    <flux:accordion.content>
                        <ul class="max-w-md space-y-1 text-xs list-disc list-inside">
                            <li class="{{ $appliedRules['min'] ? 'requirement-active' : 'requirement-inactive' }}">
                                Contains at least {{ $appliedRules['min'] }} characters
                            </li>

                            @if ($appliedRules['letters'])
                                <li>Includes letters</li>
                            @endif

                            @if ($appliedRules['mixedCase'])
                                <li>Contains both uppercase and lowercase letters</li>
                            @endif

                            @if ($appliedRules['numbers'])
                                <li>Includes at least one number</li>
                            @endif

                            @if ($appliedRules['symbols'])
                                <li>Contains at least one special character</li>
                            @endif
                        </ul>
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
