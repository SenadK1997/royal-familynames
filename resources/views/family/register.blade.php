@auth
@extends('layouts.auth')

@section("title")

RoyalFamilyNames - Register Family

@endsection
@if (Auth::user()->familynames->count() >=2 )
<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-sm bg-white bg-opacity-90 rounded-lg shadow-lg p-4">
  <h1 class="text-center">You already registered to maximum family names. If you want to support other family, you can go to existing family and click on Support this Family</h1>
</div>
@else
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
      <form class="space-y-6" action="{{ route('request.payment') }}" id="register-form" method="POST">
        @csrf
        <div>
          <label for="family_name" class="block text-sm font-medium leading-6 text-gray-900">Enter your family name</label>
          <div class="mt-2">
            <input id="family_name" name="family_name" type="text" required class="capitalize px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100">
          </div>
        </div>
        <input id="flag_url" name="flag_url" class="hidden">
        <div class="mb-4">
          <label for="country" class="block text-sm font-medium text-gray-700">From</label>
          <div class="relative mt-1">
              <input id="country" name="country" type="text" class="form-input px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100" required placeholder="Search for a country">
              <div id="countryDropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden overflow-y-scroll h-64">
                  <!-- Options will be added here dynamically -->
              </div>
          </div>
        </div>
        <div>
          <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Enter amount of support in -
            <span class="text-green-600">
              $ USD
            </span> 
          </label>
          <div class="mt-2">
            <input min="1" id="price" name="price" type="number" required class="capitalize px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100">
          </div>
        </div>
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        </div>
      </form>
      {{-- <button type="submit" class="w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" id="register-button">
        <div id="paypal-donate-button-container" class="flex mx-auto w-full justify-center"></div>
      </button> --}}
    </div>
</div>
@endsection
@endif
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
          option.setAttribute('id', 'selected-country');
          option.addEventListener('click', function() {
              countryInput.value = country.name.common;
              console.log(countryInput.value)
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
{{-- <script>
  $(document).ready(function() {
    const registerButton = $('#register-button'); // Select the button element
    
    // Initialize the button state
    registerButton.hide();
    
    // Watch for changes in input fields
    $('#family_name, #country').on('input', function() {
      updateRegisterButtonState();
    });

    // Handle the selection from the #countryDropdown
    $('#countryDropdown').on('click', 'div', function() {
      const selectedCountry = $(this).text();
      $('#country').val(selectedCountry).trigger('change');
      updateRegisterButtonState();
    });
  });

  function updateRegisterButtonState() {
    const familyName = $('#family_name').val();
    const country = $('#country').val();
    
    const registerButton = $('#register-button');

    // Show/hide the button based on input values
    if (familyName !== '' && country !== '') {
      registerButton.show();
    } else {
      registerButton.hide();
    }
  }
</script> --}}
{{-- <script>
  PayPal.Donation.Button({
      env: 'sandbox',
      hosted_button_id: 'WW3RZCD4UHNXS',
      image: {
          src: 'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif',
          title: 'PayPal - The safer, easier way to pay online!',
          alt: 'Donate with PayPal button'
      },
      onComplete: function (params) {
          var donationAmount = params.amt;
          var flagUrl = $('#flag_url').val(); // Get flag_url value
          var familyName = $('#family_name').val(); // Get family_name value
          var country = $('#country').val(); // Get country value

          // Include the CSRF token in the headers
          var csrfToken = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
              url: '/register/family',
              method: 'POST',
              data: {
                  amount: donationAmount,
                  flag_url: flagUrl,
                  family_name: familyName,
                  country: country,
              },
              headers: {
                  'X-CSRF-TOKEN': csrfToken
              },
              success: function(response) {
                  // Handle the response, e.g., show a thank-you message
                  // console.log(response);
                  alert('You successfully registered the family')
              },
              error: function(error) {
                  // Handle errors
                  console.log(error);
                  alert('Something went wrong')
              }
          });
      },
  }).render('#paypal-donate-button-container');
</script> --}}
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_LIVE_CLIENT_ID') }}"></script>
@endpush
@else
    <p>You need to be logged in to register a family.</p>
@endauth
