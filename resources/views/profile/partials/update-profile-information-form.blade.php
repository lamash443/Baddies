<section class="dash-card">
    <header>
        <h2 class="dash-card-title" style="font-size:1rem;">{{ __('Profile Information') }}</h2>
        <p class="dash-card-text" style="font-size:0.8rem;">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}">
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
            <input id="phone_number" name="phone_number" type="text" class="form-control pf-sanitise"
                data-pattern="phone"
                maxlength="15"
                placeholder="+254 7XX XXX XXX"
                value="{{ old('phone_number', $user->phone_number) }}"
                autocomplete="tel" />

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
            <input id="age" name="age" type="number" min="18" max="100" class="form-control" value="{{ old('age', $user->age) }}"
                onkeydown="if(['-', '+', 'e', 'E'].includes(event.key)) event.preventDefault();"
                oninput="if(this.value !== '' && parseInt(this.value, 10) < 0) this.value = '';"
                onblur="if(this.value !== '' && parseInt(this.value, 10) < 18) { this.value = 18; }"
                onchange="if(this.value !== '' && parseInt(this.value, 10) < 18) { this.value = 18; }"
                placeholder="18" />

            @error('age')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">{{ __('Nationality') }}</label>
            <input id="nationality" name="nationality" type="text" class="form-control pf-sanitise"
                data-pattern="name"
                maxlength="30"
                placeholder="e.g. Kenyan"
                value="{{ old('nationality', $user->nationality) }}" />
            @error('nationality')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        @php
            $kenyanCounties = ['Nairobi','Mombasa','Nakuru','Kiambu','Kisumu','Machakos','Kajiado','Uasin Gishu','Kilifi','Meru','Nyeri','Embu','Kakamega','Bungoma','Bomet','Kisii','Migori','Homa Bay','Siaya','Vihiga','Trans Nzoia','Nandi','Elgeyo Marakwet','Baringo','Laikipia','Nyandarua',"Murang'a",'Kirinyaga','Tharaka Nithi','Isiolo','Garissa','Wajir','Mandera','Marsabit','Samburu','Turkana','West Pokot','Lamu','Taita Taveta','Kwale','Tana River','Narok','Kericho','Nyamira','Rachuonyo'];
            $dbCounties = \App\Models\Location::where('is_active', true)->where('type', 'county')->orderBy('name')->pluck('name')->toArray();
            $allCounties = array_unique(array_merge($kenyanCounties, $dbCounties));
            sort($allCounties);
            $currentCounty = old('county', $user->county);
            $isCustomCounty = $currentCounty && !in_array($currentCounty, $allCounties);
        @endphp
        <div class="mb-3">
            <label for="county_select" class="form-label fw-bold">{{ __('County') }} <span class="text-danger">*</span></label>
            <select id="county_select" class="form-select" onchange="handleCountyChange(this)">
                <option value="">{{ __('Select County') }}</option>
                @foreach($allCounties as $c)
                    <option value="{{ $c }}" {{ $currentCounty === $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
                <option value="__other__" {{ $isCustomCounty ? 'selected' : '' }}>✏️ Other (type below)</option>
            </select>
            <input id="county" name="county" type="text" class="form-control pf-sanitise mt-2"
                data-pattern="name"
                maxlength="50"
                placeholder="Type your county..."
                value="{{ $isCustomCounty ? $currentCounty : ($currentCounty && !in_array($currentCounty, $allCounties) ? $currentCounty : '') }}"
                style="display: {{ $isCustomCounty ? 'block' : 'none' }};" />
            @error('county')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="city_town" class="form-label">{{ __('City / Town') }}</label>
            <input id="city_town" name="city_town" type="text" class="form-control pf-sanitise"
                data-pattern="name"
                maxlength="30"
                placeholder="e.g. Nairobi"
                value="{{ old('city_town', $user->city_town) }}" />
            @error('city_town')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        @php
            $staticLocations = ['James Gichuru Road','Southern Bypass','Gitanga Road','Naivasha Road','Northern Bypass','Eastern Bypass','Manyanja Rd','Waiyaki Way','Kiambu Road','Langata Road','Outering Road','Kangundo Road','Ngong Road','Kamiti Road','Jogoo Road','Mombasa Road','Thika Road','Allsops','Banana','Buruburu','Chokaa','Dagoretti','Dandora','Donholm','Eastlands','Eastleigh','Embakasi','Garden City','Githurai 44','Githurai 45','Homeland','Hurlingham','Huruma','Imara Daima','Jamhuri','Joska','Juja','Kabete','Kahawa Sukari','Kahawa Wendani','Kahawa West','Kamulu','Kangemi','Karen','Kariobangi','Kasarani','Kawangware','Kayole','Kenyatta Road','Kibera','Kikuyu','Kileleshwa','Kilimani','Kitengela','Kitisuru','Komarock','Langata','Lavington','Loresho','Madaraka','Makadara','Malaa','Mathare','Milimani','Mlolongo','Muthaiga','Muthangari','Muthurwa','Mwiki','Nairobi Town','Nairobi West','Ndenderu','Ngara','Ngong','Ngumba','Njiru','Pangani','Parklands','Roasters','Ongata Rongai','Roysambu','Ruai','Ruaka','Ruaraka','Ruiru','Runda','Saika','South B','South C','Syokimau','Thogoto','Thome','Umoja','Upper Hill','Utawala','Uthiru','Westlands'];
            $dbLocations = \App\Models\Location::where('is_active', true)->whereIn('type', ['road','area'])->orderBy('name')->pluck('name')->toArray();
            $allLocations = array_unique(array_merge($staticLocations, $dbLocations));
            sort($allLocations);
            $currentLocation = old('location', $user->location);
            $isCustomLocation = $currentLocation && !in_array($currentLocation, $allLocations);
        @endphp
        <div class="mb-3">
            <label for="location_select" class="form-label fw-bold">{{ __('Location') }} <span class="text-danger">*</span></label>
            <select id="location_select" class="form-select" onchange="handleLocationChange(this)">
                <option value="">{{ __('Select Location / Area') }}</option>
                @foreach($allLocations as $loc)
                    <option value="{{ $loc }}" {{ $currentLocation === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
                <option value="__other__" {{ $isCustomLocation ? 'selected' : '' }}>✏️ Other (type below)</option>
            </select>
            <input id="location" name="location" type="text" class="form-control pf-sanitise mt-2"
                data-pattern="name"
                maxlength="50"
                placeholder="Type your location..."
                value="{{ $isCustomLocation ? $currentLocation : '' }}"
                style="display: {{ $isCustomLocation ? 'block' : 'none' }};" />
            @error('location')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">{{ __('Area') }}</label>
            <input id="area" name="area" type="text" class="form-control pf-sanitise"
                data-pattern="name"
                maxlength="30"
                placeholder="e.g. Westlands"
                value="{{ old('area', $user->area) }}" />
            @error('area')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nearby_places" class="form-label">{{ __('Nearby Places') }}</label>
            <textarea id="nearby_places" name="nearby_places" class="form-control pf-sanitise"
                data-pattern="places"
                maxlength="200"
                rows="3"
                placeholder="e.g. Westgate Mall, Junction Mall">{{ old('nearby_places', $user->nearby_places) }}</textarea>

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
                            <label class="form-check-label text-white-50" for="service_{{ Str::slug($service) }}" style="font-size:0.78rem;">
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
            <input id="other_services" name="other_services" type="text" class="form-control pf-sanitise"
                data-pattern="list"
                maxlength="100"
                placeholder="e.g. Massage, Companionship"
                value="{{ old('other_services', $user->other_services) }}" />

            @error('other_services')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="incalls_rate" class="form-label">{{ __('Incalls rate') }}</label>
                <div class="input-group">
                    <input id="incalls_rate" name="incalls_rate" type="number" min="0" max="999999" class="form-control"
                        placeholder="Leave blank for ASK"
                        value="{{ old('incalls_rate', $user->incalls_rate) }}"
                        onkeydown="if(['-','+','e','E','.'].includes(event.key)) event.preventDefault();" />
                    <span class="input-group-text" style="color: #ff8c00;">Ksh</span>
                </div>

                @error('incalls_rate')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="outcalls_rate" class="form-label">{{ __('Outcalls rate') }}</label>
                <div class="input-group">
                    <input id="outcalls_rate" name="outcalls_rate" type="number" min="0" max="999999" class="form-control"
                        placeholder="Leave blank for ASK"
                        value="{{ old('outcalls_rate', $user->outcalls_rate) }}"
                        onkeydown="if(['-','+','e','E','.'].includes(event.key)) event.preventDefault();" />
                    <span class="input-group-text" style="color: #ff8c00;">Ksh</span>
                </div>

                @error('outcalls_rate')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="other_cities" class="form-label">{{ __('Other cities') }}</label>
            <input id="other_cities" name="other_cities" type="text" class="form-control pf-sanitise"
                data-pattern="list"
                maxlength="100"
                placeholder="e.g. Mombasa, Kisumu, Nakuru"
                value="{{ old('other_cities', $user->other_cities) }}" />

            @error('other_cities')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="additional_information" class="form-label mb-0 fw-semibold">{{ __('Any additional information') }}</label>
                <span class="text-white-50" style="font-size:0.75rem;" id="counter-additional_information"></span>
            </div>

            <div class="p-3 mb-2 rounded-3" style="background: rgba(255, 140, 0, 0.08); border: 1.5px dashed rgba(255, 140, 0, 0.35); font-size: 0.82rem; line-height: 1.5;">
                <div style="font-weight: 700; color: #ff8c00; margin-bottom: 0.3rem; display: flex; align-items: center; gap: 0.45rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Make Your Profile Irresistible To More Clients!
                </div>
                <div style="opacity: 0.9;">
                    Use this space to share appealing and enticing details that make you stand out and attract more clients! Mention your special touches, warm personality, cleanliness, preferred arrangements, or what makes spending time with you completely unforgettable.
                </div>
            </div>

            <textarea id="additional_information" name="additional_information" rows="4" maxlength="2500"
                class="form-control pf-sanitise"
                data-pattern="text"
                style="resize: vertical; min-height: 110px; line-height: 1.5;"
                placeholder="Write appealing details to attract more clients (e.g., your charm, special arrangements, good vibes, hygiene standards, or unique offerings)..."
            >{{ old('additional_information', $user->additional_information) }}</textarea>

            @error('additional_information')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-orange">{{ __('Save') }}</button>
            @if (session('status') === 'profile-updated')
                <p class="mb-0 text-success" style="font-size:0.9rem;" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
(function () {
  /* Allowed-character patterns per field type — anything NOT matching is stripped */
  var PATTERNS = {
    phone:  /[^0-9+\s\-]/g,
    name:   /[^a-zA-Z\u00C0-\u024F0-9\s'\-]/g,
    places: /[^a-zA-Z\u00C0-\u024F\s,.\-]/g,
    list:   /[^a-zA-Z\u00C0-\u024F\s,\-]/g,
    text:   /[^\x20-\x7E\r\n\u00C0-\u024F]/g
  };
  /* Strip emoji / symbol blocks */
  var EMOJI_RE = /[\uD800-\uDFFF\u2600-\u27BF\u2300-\u23FF\uFE00-\uFE0F]/g;

  function sanitise(el) {
    var pattern = PATTERNS[el.dataset.pattern];
    if (!pattern) return;
    var pos = el.selectionStart;
    var before = el.value;
    var after = before.replace(EMOJI_RE, '').replace(pattern, '');
    if (after !== before) {
      el.value = after;
      var removed = before.length - after.length;
      try { el.setSelectionRange(Math.max(0, pos - removed), Math.max(0, pos - removed)); } catch(e) {}
    }
    updateCounter(el);
  }

  function updateCounter(el) {
    var counter = document.getElementById('counter-' + el.id);
    if (!counter) return;
    var max = parseInt(el.getAttribute('maxlength'), 10);
    var len = el.value.length;
    counter.textContent = len + ' / ' + max;
    counter.style.color = len >= max ? '#dc3545' : len >= max * 0.85 ? '#ffc107' : '';
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.pf-sanitise').forEach(function (el) {
      el.addEventListener('input', function () { sanitise(el); });
      el.addEventListener('paste', function () { setTimeout(function () { sanitise(el); }, 0); });
      updateCounter(el);
    });
  });
})();

/* County dropdown handler */
function handleCountyChange(sel) {
  var customInput = document.getElementById('county');
  sel.classList.remove('is-invalid');
  if (customInput) customInput.classList.remove('is-invalid');

  if (sel.value === '__other__') {
    customInput.style.display = 'block';
    customInput.value = '';
    customInput.required = true;
    sel.required = false;
    customInput.focus();
  } else {
    customInput.style.display = 'none';
    customInput.required = false;
    sel.required = true;
    customInput.value = sel.value;
  }
}

/* Location dropdown handler */
function handleLocationChange(sel) {
  var customInput = document.getElementById('location');
  sel.classList.remove('is-invalid');
  if (customInput) customInput.classList.remove('is-invalid');

  if (sel.value === '__other__') {
    customInput.style.display = 'block';
    customInput.value = '';
    customInput.required = true;
    sel.required = false;
    customInput.focus();
  } else {
    customInput.style.display = 'none';
    customInput.required = false;
    sel.required = true;
    customInput.value = sel.value;
  }
}

/* On page load, sync inputs from dropdowns & enforce client-side required validation */
document.addEventListener('DOMContentLoaded', function() {
  var countySelect = document.getElementById('county_select');
  var countyInput  = document.getElementById('county');
  if (countySelect && countyInput) {
    if (countySelect.value === '__other__' || countyInput.style.display === 'block') {
      countyInput.required = true;
      countySelect.required = false;
    } else if (countySelect.value) {
      countyInput.value = countySelect.value;
      countyInput.required = false;
      countySelect.required = true;
    } else {
      countySelect.required = true;
      countyInput.required = false;
    }
  }

  var locSelect = document.getElementById('location_select');
  var locInput  = document.getElementById('location');
  if (locSelect && locInput) {
    if (locSelect.value === '__other__' || locInput.style.display === 'block') {
      locInput.required = true;
      locSelect.required = false;
    } else if (locSelect.value) {
      locInput.value = locSelect.value;
      locInput.required = false;
      locSelect.required = true;
    } else {
      locSelect.required = true;
      locInput.required = false;
    }
  }

  var form = document.getElementById('profile-update-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      var cSel = document.getElementById('county_select');
      var cInp = document.getElementById('county');
      var lSel = document.getElementById('location_select');
      var lInp = document.getElementById('location');

      var countyVal = '';
      if (cSel && cSel.value === '__other__') {
        countyVal = cInp ? cInp.value.trim() : '';
      } else if (cSel) {
        countyVal = cSel.value.trim();
      }

      var locVal = '';
      if (lSel && lSel.value === '__other__') {
        locVal = lInp ? lInp.value.trim() : '';
      } else if (lSel) {
        locVal = lSel.value.trim();
      }

      if (!countyVal) {
        e.preventDefault();
        if (cSel.value === '__other__' && cInp) {
          cInp.classList.add('is-invalid');
          cInp.focus();
        } else if (cSel) {
          cSel.classList.add('is-invalid');
          cSel.focus();
        }
        alert('County is required. Please select your county or type one to complete your profile update.');
        return false;
      }

      if (!locVal) {
        e.preventDefault();
        if (lSel.value === '__other__' && lInp) {
          lInp.classList.add('is-invalid');
          lInp.focus();
        } else if (lSel) {
          lSel.classList.add('is-invalid');
          lSel.focus();
        }
        alert('Location is required. Please select your location or type one to complete your profile update.');
        return false;
      }

      if (cInp) cInp.value = countyVal;
      if (lInp) lInp.value = locVal;
    });
  }
});
</script>
