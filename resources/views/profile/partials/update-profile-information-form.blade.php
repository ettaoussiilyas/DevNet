<section class="bg-[#F9F6E6] p-8 rounded-lg shadow-lg">
    <header>
        <h2 class="text-lg font-medium text-[#8D77AB]">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-[#8D77AB]/70">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="name" :value="__('Name')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="email" :value="__('Email')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="bg-[#BAD8B6]/20 p-3 rounded-md mt-3">
                    <p class="text-sm text-[#8D77AB]">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-[#8D77AB] hover:text-[#8D77AB]/80 rounded-md focus:outline-none focus:ring-2 focus:ring-[#BAD8B6]">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-[#8D77AB]">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="skills" :value="__('Skills')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('skills', $user->skills)" autocomplete="skills" />
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="programming_languages" :value="__('Programming Languages')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="programming_languages" name="programming_languages" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('programming_languages', $user->programming_languages)" autocomplete="programming_languages" />
            <x-input-error class="mt-2" :messages="$errors->get('programming_languages')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="projects" :value="__('Projects')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="projects" name="projects" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('projects', $user->projects)" autocomplete="projects" />
            <x-input-error class="mt-2" :messages="$errors->get('projects')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="certifications" :value="__('Certifications')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="certifications" name="certifications" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('certifications', $user->certifications)" autocomplete="certifications" />
            <x-input-error class="mt-2" :messages="$errors->get('certifications')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="github_url" :value="__('GitHub URL')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('github_url', $user->github_url)" autocomplete="github_url" />
            <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="image" :value="__('Profile Image')" class="text-[#8D77AB] font-semibold" />
            <input id="image" name="image" type="file" class="mt-1 block w-full text-[#8D77AB] file:bg-[#BAD8B6] file:border-0 file:rounded-md file:px-4 file:py-2 file:text-[#F9F6E6] hover:file:bg-[#BAD8B6]/90" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="industry" :value="__('Industry')" class="text-[#8D77AB] font-semibold" />
            <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" :value="old('industry', $user->industry)" autocomplete="industry" />
            <x-input-error class="mt-2" :messages="$errors->get('industry')" />
        </div>

        <div class="bg-[#E1EACD] p-4 rounded-lg">
            <x-input-label for="bio" :value="__('Bio')" class="text-[#8D77AB] font-semibold" />
            <textarea id="bio" name="bio" class="mt-1 block w-full bg-[#F9F6E6] border-[#BAD8B6] rounded-md focus:ring-[#8D77AB] focus:border-[#8D77AB]" rows="4">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#8D77AB] px-4 py-2 text-[#F9F6E6] rounded-md hover:bg-[#8D77AB]/90 transition-colors duration-300">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-[#BAD8B6]">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
