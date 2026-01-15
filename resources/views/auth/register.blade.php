<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- School -->
        <div class="mt-4">
            <x-input-label for="school" :value="__('School/University')" />
            <x-text-input id="school" class="block mt-1 w-full" type="text" name="school" :value="old('school')" required autocomplete="organization" placeholder="e.g., Southern de Oro Philippines College" />
            <x-input-error :messages="$errors->get('school')" class="mt-2" />
        </div>

        <!-- Required Hours -->
        <div class="mt-4">
            <x-input-label for="required_hours" :value="__('Required OJT Hours')" />
            <x-text-input id="required_hours" class="block mt-1 w-full" type="number" name="required_hours" :value="old('required_hours', 590)" required min="1" max="2000" />
            <p class="text-xs text-gray-500 mt-1">Enter your total required OJT hours (e.g., 590, 486, 300)</p>
            <p class="text-xs text-indigo-600 mt-1" id="calculated_days"></p>
            <x-input-error :messages="$errors->get('required_hours')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Calculate and display equivalent days based on required hours
        const requiredHoursInput = document.getElementById('required_hours');
        const calculatedDaysText = document.getElementById('calculated_days');

        function updateCalculatedDays() {
            const hours = parseInt(requiredHoursInput.value) || 590;
            const hoursPerDay = 7.867; // 590 hours / 75 days
            const days = Math.ceil(hours / hoursPerDay);
            calculatedDaysText.textContent = `≈ ${days} days of OJT`;
        }

        requiredHoursInput.addEventListener('input', updateCalculatedDays);
        
        // Initial calculation
        updateCalculatedDays();
    </script>
</x-guest-layout>
