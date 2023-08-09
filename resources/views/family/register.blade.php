@auth
@extends('layouts.auth')

@section("title")

RoyalFamilyNames - Register Family

@endsection

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create new family name</h2>
      @if(session('error'))
        <div class="alert alert-danger text-red-700">
            {{ session('error') }}
        </div>
      @endif
    </div>
  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="{{ route('family.register') }}" method="POST">
        @csrf
        <div>
          <label for="family_name" class="block text-sm font-medium leading-6 text-gray-900">Enter your family name</label>
          <div class="mt-2">
            <input id="family_name" name="family_name" type="text" required class="capitalize px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
        <input id="flag_url" name="flag_url" type="hidden">
        <div class="mb-4">
          <label for="country" class="block text-sm font-medium text-gray-700">From</label>
          <div class="relative mt-1">
              <input id="country" name="country" type="text" class="form-input px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Search for a country">
              <div id="countryDropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden overflow-y-scroll h-64">
                  <!-- Options will be added here dynamically -->
              </div>
          </div>
        </div>
        <div>
            <label for="valuation" class="block text-sm font-medium leading-6 text-gray-900">Amount of support</label>
            <div class="mt-2">
              <input id="valuation" min="5" name="valuation" type="number" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
        </div>
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register a family</button>
        </div>
      </form>
    </div>
</div>
@endsection
@push('script')
<script>
  const countryInput = document.getElementById('country');
  const countryDropdown = document.getElementById('countryDropdown');

  function fetchAndDisplayCountries() {
      fetch(`https://restcountries.com/v3.1/all`)
          .then(response => response.json())
          .then(data => {
              updateCountryDropdown(data);
          });
  }

  function updateCountryDropdown(countries) {
      countryDropdown.innerHTML = '';
      countries.forEach(country => {
          const option = document.createElement('div');
          option.textContent = country.name.common;
          option.classList.add('cursor-pointer', 'py-1', 'px-3', 'hover:bg-gray-100');
          option.addEventListener('click', function() {
              countryInput.value = country.name.common;
              document.getElementById('flag_url').value = country.flags.png; // Set the flag URL
              countryDropdown.classList.add('hidden');
          });
          countryDropdown.appendChild(option);
      });
      countryDropdown.classList.remove('hidden');
  }

  countryInput.addEventListener('focus', fetchAndDisplayCountries);

  countryInput.addEventListener('input', function() {
      const searchQuery = countryInput.value.toLowerCase().trim();

      fetch(`https://restcountries.com/v3.1/all`)
          .then(response => response.json())
          .then(data => {
              if (searchQuery.length === 0) {
                  updateCountryDropdown(data);
                  return;
              }

              const filteredCountries = data.filter(country => {
                  return country.name.common.toLowerCase().includes(searchQuery);
              });

              updateCountryDropdown(filteredCountries);
          });
  });

  // Close the dropdown when clicking outside
  document.body.addEventListener('click', function(event) {
      if (!countryDropdown.contains(event.target) && event.target !== countryInput) {
          countryDropdown.classList.add('hidden');
      }
  });
</script>


@endpush

@else
    <p>You need to be logged in to register a family.</p>
@endauth
