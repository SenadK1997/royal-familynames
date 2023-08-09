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
        <div class="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
          <div class="flex items-center gap-x-6">
            <img src="https://tailwindui.com/img/logos/48x48/tuple.svg" alt="" class="h-16 w-16 flex-none rounded-full ring-1 ring-gray-900/10">
            <h1>
              <div class="mt-1 text-base font-semibold leading-6 text-gray-900">{{ $user->name }}</div>
              <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">{{ $user->account_id }}</div>
            </h1>
          </div>
          <div class="flex items-center gap-x-4 sm:gap-x-6">
            <div class="flex flex-col items-center relative">
              <button class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" id="toggleButton">Register to existing family name</button>
              <div id="otherFileContent" class="hidden absolute top-full left-0 w-full z-10 p-4 bg-white shadow-md">
                  {{-- @include('partials.existing-family-names') --}}
                  @include('partials.existing-family-names', ['families' => $families])
              </div>
            </div>
            <a href="/register/family" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register new family name</a>
  
            <div class="relative sm:hidden">
              <button type="button" class="-m-3 block p-3" id="more-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">More</span>
                <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                </svg>
              </button>
              <div class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="more-menu-button" tabindex="-1">
                <!-- Active: "bg-gray-50", Not Active: "" -->
                <button type="button" class="block w-full px-3 py-1 text-left text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="more-menu-item-0">Copy URL</button>
                <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="more-menu-item-1">Edit</a>
              </div>
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
          $highestValuationFamily = $userAttachedFamilies->sortByDesc('valuation')->first();
      @endphp

      {{-- First family --}}
      <div class="w-full min-w-sm mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
          <h5 class="mb-4 text-2xl font-medium text-gray-500 dark:text-gray-400 flex mx-auto w-full justify-center gap-x-2">Your Family name
              <a href="/family/{{ $highestValuationFamily->family_code }}" class="text-blue-500">
                  {{ $highestValuationFamily->family_name }}
              </a>
              rank is:
          </h5>
          <div class="flex items-baseline text-gray-900 dark:text-white mx-auto w-full justify-center">
              <span class="text-9xl font-extrabold tracking-tight text-[#525782]">{{ $rank }}</span>
          </div>
          <ul role="list" class="space-y-5 my-7">
            <li class="flex space-x-3 items-center mx-auto w-full justify-center">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">{{ $numberOfUsersFirstFamily }} Family member/s</span>
            </li>
        </ul>
          <button type="button" class="gap-x-2 items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
              <span class="text-xl font-normal tracking-tight text-gray-100">Total family name valuation: </span>
              <div>
                  <span class="text-2xl font-extrabold tracking-tight text-green-300">{{ $highestValuationFamily->valuation }}<span class="text-lg font-bold tracking-tight">.00</span></span>
                  <span class="text-xl font-semibold text-green-300">$</span>
              </div>
          </button>
      </div>
      {{-- Second familyname --}}
      @if ($userAttachedFamilies->count() > 1)
      <div class="w-full min-w-sm mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-4 text-2xl font-medium text-gray-500 dark:text-gray-400 flex mx-auto w-full justify-center gap-x-2">Your Family name
          <a href="/family/{{ $userAttachedFamilies->skip(1)->first()->family_code }}" class="text-blue-500">
            {{ $userAttachedFamilies->skip(1)->first()->family_name }}
          </a>
          rank is:
        </h5>
        <div class="flex items-baseline text-gray-900 dark:text-white mx-auto w-full justify-center">
          <span class="text-9xl font-extrabold tracking-tight text-[#525782]">{{ $secondFamilyRank }}</span>
        </div>
        <ul role="list" class="space-y-5 my-7">
            <li class="flex space-x-3 items-center mx-auto w-full justify-center">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">{{ $numberOfUsersSecondFamily }} Family member/s</span>
            </li>
        </ul>
        <button type="button" class="gap-x-2 items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
          <span class="text-xl font-normal tracking-tight text-gray-100">Total family name valuation: </span>
          <div>
            <span class="text-2xl font-extrabold tracking-tight text-green-300">{{ $userAttachedFamilies->skip(1)->first()->valuation }}<span class="text-lg font-bold tracking-tight">.00</span></span>
            <span class="text-xl font-semibold text-green-300">$</span>
          </div>
          </button>
      </div>
      @endif
      @endif
  </main>
  
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