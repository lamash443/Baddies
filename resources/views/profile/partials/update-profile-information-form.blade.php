<section class="dash-card">
    <header>
        <h2 class="dash-card-title">{{ __('Profile Information') }}</h2>
        <p class="dash-card-text">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" readonly style="cursor: not-allowed;" autocomplete="name" />
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" readonly style="cursor: not-allowed;" autocomplete="username" />
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror

        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
            <input id="phone_number" name="phone_number" type="text" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" autocomplete="tel" />
            @error('phone_number')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">{{ __('Gender') }}</label>
            <select id="gender" name="gender" class="form-select">
                <option value="">{{ __('Select Gender') }}</option>
                <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="Other" {{ old('gender', $user->gender) === 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="sexual_orientation" class="form-label">{{ __('Sexual Orientation') }}</label>
            <select id="sexual_orientation" name="sexual_orientation" class="form-select">
                <option value="">{{ __('Select Orientation') }}</option>
                <option value="Straight" {{ old('sexual_orientation', $user->sexual_orientation) === 'Straight' ? 'selected' : '' }}>{{ __('Straight') }}</option>
                <option value="Gay" {{ old('sexual_orientation', $user->sexual_orientation) === 'Gay' ? 'selected' : '' }}>{{ __('Gay') }}</option>
                <option value="Lesbian" {{ old('sexual_orientation', $user->sexual_orientation) === 'Lesbian' ? 'selected' : '' }}>{{ __('Lesbian') }}</option>
                <option value="Bisexual" {{ old('sexual_orientation', $user->sexual_orientation) === 'Bisexual' ? 'selected' : '' }}>{{ __('Bisexual') }}</option>
                <option value="Other" {{ old('sexual_orientation', $user->sexual_orientation) === 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            @error('sexual_orientation')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">{{ __('Age') }}</label>
            <input id="age" name="age" type="number" min="18" max="100" class="form-control" value="{{ old('age', $user->age) }}" />
            @error('age')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">{{ __('Nationality') }}</label>
            <input id="nationality" name="nationality" type="text" class="form-control" value="{{ old('nationality', $user->nationality) }}" />
            @error('nationality')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="county" class="form-label">{{ __('County') }}</label>
            <input id="county" name="county" type="text" class="form-control" value="{{ old('county', $user->county) }}" list="county-list" />
            <datalist id="county-list">
                @foreach(['Mombasa','Nakuru','Kiambu','Kisumu','Machakos','Kajiado','Uasin Gishu','Kilifi','Meru','Nyeri','Embu','Kakamega','Bungoma','Bomet','Kisii','Migori','Homa Bay','Siaya','Vihiga','Trans Nzoia','Nandi','Elgeyo Marakwet','Baringo','Laikipia','Nyandarua','Murang\'a','Kirinyaga','Tharaka Nithi','Isiolo','Garissa','Wajir','Mandera','Marsabit','Samburu','Turkana','West Pokot','Lamu','Taita Taveta','Kwale','Tana River','Narok','Kericho','Nyamira','Rachuonyo'] as $county)
                    <option value="{{ $county }}">
                @endforeach
            </datalist>
            @error('county')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="city_town" class="form-label">{{ __('City / Town') }}</label>
            <input id="city_town" name="city_town" type="text" class="form-control" value="{{ old('city_town', $user->city_town) }}" />
            @error('city_town')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">{{ __('Location') }}</label>
            <input id="location" name="location" type="text" class="form-control" value="{{ old('location', $user->location) }}" list="location-list" />
            <datalist id="location-list">
                @foreach(['James Gichuru Road','Southern Bypass','Gitanga Road','Naivasha Road','Northern Bypass','Eastern Bypass','Manyanja Rd','Waiyaki Way','Kiambu Road','Langata Road','Outering Road','Kangundo Road','Ngong Road','Kamiti Road','Jogoo Road','Mombasa Road','Thika Road','Allsops','Banana','Buruburu','Chokaa','Dagoretti','Dandora','Donholm','Eastlands','Eastleigh','Embakasi','Garden City','Githurai 44','Githurai 45','Homeland','Hurlingham','Huruma','Imara Daima','Jamhuri','Joska','Juja','Kabete','Kahawa Sukari','Kahawa Wendani','Kahawa West','Kamulu','Kangemi','Karen','Kariobangi','Kasarani','Kawangware','Kayole','Kenyatta Road','Kibera','Kikuyu','Kileleshwa','Kilimani','Kitengela','Kitisuru','Komarock','Langata','Lavington','Loresho','Madaraka','Makadara','Malaa','Mathare','Milimani','Mlolongo','Muthaiga','Muthangari','Muthurwa','Mwiki','Nairobi Town','Nairobi West','Ndenderu','Ngara','Ngong','Ngumba','Njiru','Pangani','Parklands','Roasters','Ongata Rongai','Roysambu','Ruai','Ruaka','Ruaraka','Ruiru','Runda','Saika','South B','South C','Syokimau','Thogoto','Thome','Umoja','Upper Hill','Utawala','Uthiru','Westlands'] as $loc)
                    <option value="{{ $loc }}">
                @endforeach
            </datalist>
            @error('location')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">{{ __('Area') }}</label>
            <input id="area" name="area" type="text" class="form-control" value="{{ old('area', $user->area) }}" />
            @error('area')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nearby_places" class="form-label">{{ __('Nearby Places') }}</label>
            <textarea id="nearby_places" name="nearby_places" class="form-control" rows="3">{{ old('nearby_places', $user->nearby_places) }}</textarea>
            @error('nearby_places')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Services') }}</label>
            @php
                $selectedServices = old('services', $user->services ?? []);
                if (is_string($selectedServices)) {
                    $selectedServices = json_decode($selectedServices, true) ?: explode(',', $selectedServices);
                }
                $selectedServices = is_array($selectedServices) ? $selectedServices : [];
            @endphp
            <div class="row g-2">
                @foreach(['Incall Sex', 'Outcall Sex', 'Erotic Massage', 'Erotic Dancing', 'Video Calls', 'VIP Companionship', 'BDSM', 'Dinner Date', 'Travel Companion', 'Lesbian Show', 'Rimming', 'Raw BJ', 'BJ', 'Girlfriend Experience', 'COB – Cum On Body', 'CIM – Cum In Mouth', '3 Some', 'Anal', 'Massage'] as $service)
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service }}" id="service_{{ Str::slug($service) }}"
                                {{ in_array($service, $selectedServices) ? 'checked' : '' }}>
                            <label class="form-check-label text-white-50" for="service_{{ Str::slug($service) }}">
                                {{ $service }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('services')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="other_services" class="form-label">{{ __('Other services') }}</label>
            <input id="other_services" name="other_services" type="text" class="form-control" value="{{ old('other_services', $user->other_services) }}" />
            @error('other_services')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="incalls_rate" class="form-label">{{ __('Incalls rate') }}</label>
                <div class="input-group">
                    <input id="incalls_rate" name="incalls_rate" type="number" min="0" class="form-control" value="{{ old('incalls_rate', $user->incalls_rate) }}" />
                    <span class="input-group-text" style="color: #ff8c00;">Ksh</span>
                </div>
                @error('incalls_rate')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="outcalls_rate" class="form-label">{{ __('Outcalls rate') }}</label>
                <div class="input-group">
                    <input id="outcalls_rate" name="outcalls_rate" type="number" min="0" class="form-control" value="{{ old('outcalls_rate', $user->outcalls_rate) }}" />
                    <span class="input-group-text" style="color: #ff8c00;">Ksh</span>
                </div>
                @error('outcalls_rate')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="other_cities" class="form-label">{{ __('Other cities') }}</label>
            <input id="other_cities" name="other_cities" type="text" class="form-control" value="{{ old('other_cities', $user->other_cities) }}" />
            @error('other_cities')<div class="text-danger">{{ $message }}</div>@enderror
        </div>



        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-orange">{{ __('Save') }}</button>
            @if (session('status') === 'profile-updated')
                <p class="mb-0 text-success" style="font-size:0.9rem;" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
