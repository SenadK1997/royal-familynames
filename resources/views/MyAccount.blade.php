@auth
@extends('layouts.account')

@section('title')

{{ $account_id}}

@endsection

@section('content')
  <main>
    <header class="relative isolate pt-2">
      <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute left-16 top-full -mt-16 transform-gpu opacity-50 blur-3xl xl:left-1/2 xl:-ml-80">
          <div class="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#FF80B5] to-[#9089FC]" style="clip-path: polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)"></div>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-px bg-gray-900/5"></div>
      </div>
  
      <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none max-md:flex-col max-md:gap-y-2">
          <div class="flex items-center gap-x-6">
            @if (Auth::user()->avatar === null)
              <span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100">
                <svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24">
                  <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </span>
              @else
              <span class="relative inline-block">
                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/images/' . Auth::user()->avatar) }}" alt="">
              </span>
            @endif
            <h1>
              <div class="mt-1 text-base font-semibold leading-6 text-gray-900 px-1">{{ $user->name }}</div>
              <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">{{ $user->account_id }}</div>
            </h1>
          </div>
          <div class="flex flex-col">          
            <div class="flex items-center gap-x-4 sm:gap-x-6 max-md:flex-col max-md:gap-y-2">
              <div class="flex flex-col items-center relative">
                <button class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" id="toggleButton">Register to existing family name</button>
                <div id="otherFileContent" class="hidden absolute top-full left-0 w-full z-10 p-4 bg-white shadow-md">
                    @include('partials.existing-family-names', ['families' => $families])
                </div>
              </div>
              <a href="/register/family" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register new family name</a>
            </div>
            <div class="flex items-center gap-x-4 max-md:flex-col">
              <div class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-6 justify-center flex items-center max-md:mt-2">
                Total money spent:
                <span class="text-green-300 font-semibold">
                  @if (Auth::user()->price_paid === null)
                  0.00 $
                  @else
                  {{ Auth::user()->price_paid }}.00 $
                  @endif
                </span>
              </div>
                <button type="button" data-modal-target="crypto-modal" data-modal-toggle="crypto-modal" class="rounded-lg mt-6 max-md:mt-2 flex justify-center items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                  Supported family list
                </button>
            </div>
          </div>
        </div>
      </div>
    </header>
      @if (Auth::user()->familynames()->count() === 0)
        <div class="w-full min-w-sm mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
          <h1 class="text-red-500">You didn't register to any family yet</h1>
        </div>
      @else
      {{-- Get the family with the highest valuation --}}
      @php
          $highestValuationFamilies = $userAttachedFamilies->sortByDesc('valuation')->values()->all();
          // dd($highestValuationFamilies);
      @endphp

      @if(session('success'))
        <div class="alert alert-danger text-green-700">
            {{ session('success') }}
        </div>
      @endif
      {{-- First family --}}
      <div class="w-full min-w-sm mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
          <h5 class="mb-4 text-2xl font-medium text-gray-500 dark:text-gray-300 flex mx-auto w-full justify-center gap-x-2">Your Family name
              <a href="/family/{{ $highestValuationFamilies[0]->family_code }}" class="text-blue-500">
                  {{ $highestValuationFamilies[0]->family_name }}
              </a>
              rank is:
          </h5>
          <div class="flex items-baseline text-gray-900 dark:text-white mx-auto w-full justify-center">
              <span class="text-9xl font-extrabold tracking-tight {{ $rank === 1 ? 'text-[#FFD700] font-bold' : ($rank === 2 ? 'text-[#C0C0C0]' : ($rank === 3 ? 'text-[#CD7F32]' : 'text-gray-800')) }}">
                {{ $rank }}
              </span>
          </div>
          <ul role="list" class="space-y-5 my-7">
            <li class="flex space-x-3 items-center mx-auto w-full justify-center">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-300">{{ $numberOfUsersFirstFamily }} Family member/s</span>
            </li>
        </ul>
          <button type="button" class="gap-x-2 items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
              <span class="text-xl font-normal tracking-tight text-gray-100">Total valuation: </span>
              <div class="whitespace-nowrap">
                  <span class="text-2xl font-extrabold tracking-tight text-green-300">{{ $highestValuationFamilies[0]->valuation }}<span class="text-lg font-bold tracking-tight">.00</span></span>
                  <span class="text-xl font-semibold text-green-300">$</span>
              </div>
          </button>
      </div>
      {{-- Second familyname --}}
      @if ($userAttachedFamilies->count() > 1)
      <div class="w-full min-w-sm mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-4 text-2xl font-medium text-gray-500 dark:text-gray-300 flex mx-auto w-full justify-center gap-x-2">Your Family name
          <a href="/family/{{ $highestValuationFamilies[1]->family_code }}" class="text-blue-500">
            {{ $highestValuationFamilies[1]->family_name }}
          </a>
          rank is:
        </h5>
        <div class="flex items-baseline text-gray-900 dark:text-white mx-auto w-full justify-center">
          <span class="text-9xl font-extrabold tracking-tight {{ $secondFamilyRank === 1 ? 'text-[#FFD700] font-bold' : ($secondFamilyRank === 2 ? 'text-[#C0C0C0]' : ($secondFamilyRank === 3 ? 'text-[#CD7F32]' : 'text-gray-800')) }}">{{ $secondFamilyRank }}</span>
        </div>
        <ul role="list" class="space-y-5 my-7">
            <li class="flex space-x-3 items-center mx-auto w-full justify-center">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-300">{{ $numberOfUsersSecondFamily }} Family member/s</span>
            </li>
        </ul>
        <button type="button" class="gap-x-2 items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
          <span class="text-xl font-normal tracking-tight text-gray-100">Total valuation: </span>
          <div class="whitespace-nowrap">
            <span class="text-2xl font-extrabold tracking-tight text-green-300">{{ $highestValuationFamilies[1]->valuation }}<span class="text-lg font-bold tracking-tight">.00</span></span>
            <span class="text-xl font-semibold text-green-300">$</span>
          </div>
          </button>
      </div>
      @endif
      @endif
  </main>


  <!-- Main modal -->
<div id="crypto-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="crypto-modal">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
          </button>
          <!-- Modal header -->
          <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
              <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                  Supported families
              </h3>
          </div>
          <!-- Modal body -->
          <div class="p-6">
              <ul class="my-4 space-y-3">
                @if ($userSupported->isEmpty())
                    <li>
                       <div>{{ $user->name }} did not supported any family yet.</div>
                    </li>
                @else
                @foreach ($userSupported as $supportedFamily)
                <li>
                  <a href="/family/{{ $supportedFamily->family_code }}" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                    <span class="flex-1 ml-3 text-zinc-500 whitespace-nowrap dark:text-white">{{ $supportedFamily->family_name }}</span>
                    <span class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-green-700 bg-gray-200 rounded dark:bg-gray-700 dark:text-green-300">{{ $supportedFamily->support->support_amount }}.00 $</span>
                  </a>
                </li>
                @endforeach
                @endif
              </ul>
          </div>
      </div>
  </div>
</div>
  
@endsection
@push('script')
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleButton = document.getElementById("toggleButton");
      const otherFileContent = document.getElementById("otherFileContent"); // Assuming you have an element for the other Blade file content

      toggleButton.addEventListener("click", function () {
          otherFileContent.classList.toggle("hidden");
      });
    });
  </script>
@endpush
@endauth