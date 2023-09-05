@auth
@extends('layouts.auth')

@section("title")

RoyalFamilyNames - Register to existing family name

@endsection
@if (Auth::user()->familynames->count() >=2 )
<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-sm bg-white bg-opacity-90 rounded-lg shadow-lg p-4">
  <h1 class="text-center">You already registered to maximum family names. If you want to support other family, you can go to existing family and click on Support this Family</h1>
</div>
@else
@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm flex flex-col">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Register to existing family name</h2>
        <div class="flex w-full mx-auto text-red-500 justify-center text-lg font-bold">{{ $family->family_code }}</div>
    </div>
  
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="{{ route('request.existing') }}" method="POST">
        @csrf
        <div>
          <label for="family_name" class="block text-sm font-medium leading-6 text-gray-900">Family name</label>
          @if(session('error'))
            <div class="alert alert-danger text-red-700">
                {{ session('error') }}
            </div>
          @endif
          <div class="mt-2">
            <input id="family_name" name="family_name" type="text" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100" disabled value="{{ $family->family_name }}">
          </div>
          <input type="text" id="family_code" name="family_code" value="{{ $family->family_code}}" class="hidden">
        </div>
          <div>
            <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country origin</label>
            <div class="mt-2">
              <input id="country" name="country" type="text" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100" disabled value="{{ $family->country }}">
            </div>
          </div>
          <div>
            <label for="price" class="block text-sm font-medium leading-6 text-gray-900">
              Enter amount of support in -
              <span class="text-green-600">
                $ USD
              </span> 
            </label>
            <div class="mt-2">
              <input min="1" id="price" name="price" type="number" required class="capitalize px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-100">
            </div>
          </div>
          <div>
            <p class="text-gray-600 text-sm">
              By registering, you accept
              <a target="_blank" href="{{ route('terms') }}" class="text-blue-500 hover:underline">Terms and Agreements</a>
            </p>
          </div>
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
          </div>
      </form>
      {{-- <div id="paypal-donate-button-container" class="mt-2 flex mx-auto w-full justify-center"></div> --}}
    </div>
  </div>
@endsection
@endif
@push('script')
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
          const donationAmount = params.amt;
          const familyName = $('#family_name').val(); // Get family_name value
          const familyCode = $('#family_code').val();

          // Include the CSRF token in the headers
          let csrfToken = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
              url: '/register/existing/family',
              method: 'POST',
              data: {
                  amount: donationAmount,
                  family_name: familyName,
                  family_code: familyCode
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
@endauth