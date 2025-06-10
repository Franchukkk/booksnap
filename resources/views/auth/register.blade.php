<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Surname -->
        <div class="mt-4">
            <x-input-label for="surname" :value="__('Surname')" />
            <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full" required>
                <option value="">-- Select Role --</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="librarian">Librarian</option>
                <option value="admin">Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- School Select -->
        <div id="school-select-wrapper" class="mt-4 hidden">
            <x-input-label for="school_id" :value="__('School')" />
            <select id="school_id" name="school_id" class="block mt-1 w-full">
                <option value="">-- Select School --</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
        </div>

        <!-- Class Select -->
        <div id="class-select-wrapper" class="mt-4 hidden">
            <x-input-label for="class_id" :value="__('Class')" />
            <select id="class_id" name="class_id" class="block mt-1 w-full">
                <option value="">-- Select Class --</option>
            </select>
            <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const schoolSelectWrapper = document.getElementById('school-select-wrapper');
        const schoolSelect = document.getElementById('school_id');
        const classSelectWrapper = document.getElementById('class-select-wrapper');
        const classSelect = document.getElementById('class_id');

        const allClasses = @json($classes);

        roleSelect.addEventListener('change', handleRoleChange);
        schoolSelect.addEventListener('change', handleSchoolChange);

        function handleRoleChange() {
            const role = roleSelect.value;

            if (role && role !== 'admin') {
                schoolSelectWrapper.classList.remove('hidden');

                if (role === 'student' || role === 'teacher') {
                    if (schoolSelect.value) {
                        showClassSelect(schoolSelect.value);
                    }
                    classSelectWrapper.classList.remove('hidden');
                } else {
                    classSelectWrapper.classList.add('hidden');
                }
            } else {
                schoolSelectWrapper.classList.add('hidden');
                classSelectWrapper.classList.add('hidden');
            }
        }

        function handleSchoolChange() {
            const selectedSchoolId = schoolSelect.value;

            if ((roleSelect.value === 'student' || roleSelect.value === 'teacher') && selectedSchoolId) {
                showClassSelect(selectedSchoolId);
                classSelectWrapper.classList.remove('hidden');
            } else {
                classSelectWrapper.classList.add('hidden');
            }
        }

        function showClassSelect(schoolId) {
            const filteredClasses = allClasses.filter(cls => cls.school_id == schoolId);
            classSelect.innerHTML = '<option value="">-- Select Class --</option>';
            filteredClasses.forEach(cls => {
                const option = document.createElement('option');
                option.value = cls.id;
                option.textContent = cls.name;
                classSelect.appendChild(option);
            });
        }

        // Ініціалізація при завантаженні
        document.addEventListener('DOMContentLoaded', () => {
            handleRoleChange();
            if (schoolSelect.value) {
                showClassSelect(schoolSelect.value);
            }
        });
    </script>
</x-guest-layout>