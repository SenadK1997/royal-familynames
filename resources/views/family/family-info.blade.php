@extends('layouts.master')
@section('title')
    RoyalFamilyNames - Family Page
@endsection

@section('content')
  @include('partials.loading')
  <main class="w-full mx-auto flex flex-col justify-center flex-wrap max-md:flex max-md:flex-col">
    <div class="relative max-md:max-w-full isolate overflow-hidden pt-16 lg:mx-auto">
      <header class="pb-4 pt-6 sm:pb-6">
        <div class="max-md:gap-y-4 mx-auto max-md:flex max-md:flex-col flex max-w-7xl lg:max-w-full lg:w-[1280px] flex-wrap items-center gap-6 max-md:gap-0 px-4 lg:px-8 max-md:px-0">
          <div class="flex">
            <h2 class="flex font-semibold leading-6 text-gray-900 lg:mx-0 lg:max-w-none text-2xl text-[#525782]">{{ $family->family_name }}'s family</h2>
          </div>
          <a href="{{ route('support.family', ['family_code' => $family->family_code])}}" class="max-md:ml-0 max-md:gap-x-0 ml-auto flex items-center gap-x-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <svg class="-ml-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M10.75 6.75a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" />
            </svg>
            Support this family
          </a>
        </div>
      </header>
      <div class="flex justify-center w-full border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5 max-md:max-w-full max-md:w-full max-md:mx-auto">
        <div class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
            <div class="max-md:py-4 flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-8 sm:px-6 lg:border-t-0 xl:px-8">
              <div class="text-lg font-medium leading-6 text-gray-500 text-center w-full">Total valuation:</div>
              <div class="w-full flex-none text-3xl text-green-600 font-medium leading-10 tracking-tight text-gray-900 text-center">{{ $family->valuation }}.00 $</div>
            </div>
            @foreach ($users->sortByDesc('pivot.supported_amount')->take(3) as $index => $supporter)
                <div class="max-md:py-4 flex text-center items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-8 sm:px-6 lg:border-t-0 xl:px-8 max-md:flex max-md:flex-col">
                    <div class="text-lg font-bold leading-6 text-gray-700 flex items-center gap-x-2 justify-center flex w-full">
                      @if ($supporter->avatar === null)
                          <span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100">
                            <svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24">
                              <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                          </span>
                          @else
                          <span class="relative inline-block">
                            <img class="h-8 w-8 rounded-full" src="{{ asset('storage/images/' . $supporter->avatar) }}" alt="">
                          </span>
                          @endif
                      {{ $supporter->name }}
                    </div>
                    <dd class="text-xs font-medium text-rose-600 flex w-full justify-center text-center">
                        <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">{{ $supporter->account_id }}</div>
                    </dd>
                    <dd class="w-full flex-none text-2xl font-medium leading-10 tracking-tight text-green-700">
                        {{ $supporter->pivot->supported_amount }}.00 $
                    </dd>
                </div>
            @endforeach
        </div>
      </div>
      <div class="absolute left-0 top-full -z-10 mt-96 origin-top-left translate-y-40 -rotate-90 transform-gpu opacity-20 blur-3xl sm:left-1/2 sm:-ml-96 sm:-mt-10 sm:translate-y-0 sm:rotate-0 sm:transform-gpu sm:opacity-50" aria-hidden="true">
        <div class="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#FF80B5] to-[#9089FC]" style="clip-path: polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)"></div>
      </div>
    </div>
    <div class="space-y-16 py-8 xl:space-y-20 max-lg:mx-auto lg:mx-auto lg:max-w-full lg:w-[1280px] max-md:w-full">
      <div>
        <div class="mt-2 overflow-hidden border-t border-gray-100">
          <div class="mx-auto max-w-7xl px-4 lg:px-8 max-md:max-w-full max-md:flex">
            <div class="mx-auto max-w-2xl max-md:max-w-full max-md:w-full lg:mx-0 lg:max-w-none">
              <div class="w-full text-left">
                <div class="sr-only">
                  <div class="flex">
                    <div class="w-1/3">Amount</div>
                    <div class="hidden sm:table-cell w-1/3">Client</div>
                    <div class="w-1/3">More details</div>
                  </div>
                </div>
                <div class="mx-auto max-md:flex max-md:flex-col max-md:mx-auto max-md:max-w-full max-md:divide-y max-md:divide-gray-200 max-md:table-auto">
                  <div class="text-sm leading-6 text-gray-900 flex gap-x-6">
                    <div class="relative isolate py-2 font-semibold" colspan="3">
                      <h3>Family members</h3>
                      <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                      <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                    </div>
                  </div>
                  {{-- MEMBERS --}}
                  @if ($users->count() > 0)
                  <div class="max-h-[250px] px-3 overflow-y-scroll w-full max-md:max-h-[400px]">
                  @foreach ($users as $user)
                  <div class="flex items-center w-full justify-between max-md:flex max-md:flex-col max-md:mx-auto max-md:w-full max-md:border-b-2 max-md:justify-center">
                    <div class="relative py-5 pr-6 max-md:mx-auto">
                      <div class="flex gap-x-6 items-center">
                        @if ($user->avatar === null)
                          <span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100">
                            <svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24">
                              <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                          </span>
                        @else
                          <span class="relative inline-block">
                            <img class="h-8 w-8 rounded-full" src="{{ asset('storage/images/' . $user->avatar) }}" alt="">
                          </span>
                        @endif
                        <div class="flex-auto">
                          <div class="flex items-start gap-x-3">
                            <div class="text-sm font-medium leading-6 text-gray-900">{{ $user->name }}</div>
                            <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">{{ $user->account_id }}</div>
                          </div>
                          <div class="flex mt-1 text-xs leading-5 text-gray-500 items-center gap-x-2">
                            <p>Total paid amount:</p>
                            <div class="flex flex-col">
                              @foreach ($user->familynames as $userSupported)  
                                <div class="flex">
                                  <p class="text-gray-400 font-bold">{{ $userSupported->family_name }}:&nbsp;</p>
                                  <p class="text-green-700 font-bold">{{ $userSupported->pivot->supported_amount }}.00 $</p>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100 max-md:hidden"></div>
                      <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100 max-md:hidden"></div>
                    </div>
                    @if ($user->website_url === null && $user->instagram_url === null && $user->linkedin_url === null && $user->twitter_url === null && $user->tiktok_url === null)
                        <div class="text-blue-700 flex px-5 py-8 items-center gap-x-4 max-md:w-full max-md:justify-center max-md:py-2">No links to social media</div>
                    @else
                    <div class="flex px-5 py-8 items-center gap-x-4 max-md:w-full max-md:justify-center max-md:py-2">
                      @if ($user->website_url)
                        <a href="{{ $user->website_url }}">
                          <svg stroke="currentColor" fill="blue" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.514,2,12,2z M4,12c0-0.899,0.156-1.762,0.431-2.569L6,11l2,2 v2l2,2l1,1v1.931C7.061,19.436,4,16.072,4,12z M18.33,16.873C17.677,16.347,16.687,16,16,16v-1c0-1.104-0.896-2-2-2h-4v-2v-1 c1.104,0,2-0.896,2-2V7h1c1.104,0,2-0.896,2-2V4.589C17.928,5.778,20,8.65,20,12C20,13.835,19.373,15.522,18.33,16.873z"></path></svg>
                        </a>
                      @endif
                      @if ($user->instagram_url)
                        <a href="{{ $user->instagram_url }}">
                          <svg stroke="#405DE6" fill="#833AB4" stroke-width="20px" viewBox="0 0 1024 1024" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M512 306.9c-113.5 0-205.1 91.6-205.1 205.1S398.5 717.1 512 717.1 717.1 625.5 717.1 512 625.5 306.9 512 306.9zm0 338.4c-73.4 0-133.3-59.9-133.3-133.3S438.6 378.7 512 378.7 645.3 438.6 645.3 512 585.4 645.3 512 645.3zm213.5-394.6c-26.5 0-47.9 21.4-47.9 47.9s21.4 47.9 47.9 47.9 47.9-21.3 47.9-47.9a47.84 47.84 0 0 0-47.9-47.9zM911.8 512c0-55.2.5-109.9-2.6-165-3.1-64-17.7-120.8-64.5-167.6-46.9-46.9-103.6-61.4-167.6-64.5-55.2-3.1-109.9-2.6-165-2.6-55.2 0-109.9-.5-165 2.6-64 3.1-120.8 17.7-167.6 64.5C132.6 226.3 118.1 283 115 347c-3.1 55.2-2.6 109.9-2.6 165s-.5 109.9 2.6 165c3.1 64 17.7 120.8 64.5 167.6 46.9 46.9 103.6 61.4 167.6 64.5 55.2 3.1 109.9 2.6 165 2.6 55.2 0 109.9.5 165-2.6 64-3.1 120.8-17.7 167.6-64.5 46.9-46.9 61.4-103.6 64.5-167.6 3.2-55.1 2.6-109.8 2.6-165zm-88 235.8c-7.3 18.2-16.1 31.8-30.2 45.8-14.1 14.1-27.6 22.9-45.8 30.2C695.2 844.7 570.3 840 512 840c-58.3 0-183.3 4.7-235.9-16.1-18.2-7.3-31.8-16.1-45.8-30.2-14.1-14.1-22.9-27.6-30.2-45.8C179.3 695.2 184 570.3 184 512c0-58.3-4.7-183.3 16.1-235.9 7.3-18.2 16.1-31.8 30.2-45.8s27.6-22.9 45.8-30.2C328.7 179.3 453.7 184 512 184s183.3-4.7 235.9 16.1c18.2 7.3 31.8 16.1 45.8 30.2 14.1 14.1 22.9 27.6 30.2 45.8C844.7 328.7 840 453.7 840 512c0 58.3 4.7 183.2-16.2 235.8z"></path></svg>
                        </a>
                      @endif
                      @if ($user->linkedin_url)
                        <a href="{{ $user->linkedin_url }}">
                          <svg stroke="currentColor" fill="#0A66C2" stroke-width="0" viewBox="0 0 1024 1024" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M880 112H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V144c0-17.7-14.3-32-32-32zM349.3 793.7H230.6V411.9h118.7v381.8zm-59.3-434a68.8 68.8 0 1 1 68.8-68.8c-.1 38-30.9 68.8-68.8 68.8zm503.7 434H675.1V608c0-44.3-.8-101.2-61.7-101.2-61.7 0-71.2 48.2-71.2 98v188.9H423.7V411.9h113.8v52.2h1.6c15.8-30 54.5-61.7 112.3-61.7 120.2 0 142.3 79.1 142.3 181.9v209.4z"></path></svg>
                        </a>
                      @endif
                      @if ($user->twitter_url)
                        <a href="{{ $user->twitter_url }}">
                          <svg stroke="currentColor" fill="#1DA1F2" stroke-width="0" viewBox="0 0 512 512" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                        </a>
                      @endif
                      @if ($user->tiktok_url)
                        <a href="{{ $user->tiktok_url }}" target="_blank">
                          <svg stroke="#00f2ea" fill="#ff0050" stroke-width="2" role="img" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><title></title><path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"></path></svg>
                        </a>
                      @endif
                    </div>
                    @endif
                    <div class="py-5 text-right max-md:w-full max-md:justify-center max-md:text-center">
                      <button class="text-sm font-medium leading-6 text-indigo-600 hover:text-indigo-500 view-quote-button"
                              data-user-id="{{ $user->id }}"
                              data-modal-target="quoteModal">
                          View {{ $user->name }} Quote
                      </button>
                      <!-- Modal -->
                      <div id="quoteModal" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="top-[30%] relative w-full max-w-md max-h-full mx-auto my-16">
                            <div class="bg-white rounded-lg shadow dark:bg-gray-600">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="quoteModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                  <div id="modalContent" class="p-6 text-center">
                                    <!-- Quote content will be inserted here -->
                                  </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  </div>
                  @else
                        <p>No users found in this family.</p>
                  @endif
                  <div class="text-sm leading-6 text-gray-900">
                    <div class="relative isolate py-2 font-semibold">
                      <h3>Family supporters</h3>
                      <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                      <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                    </div>
                  </div>
                  {{-- SUPPORTERS --}}
                  @if ($supporters->isEmpty())
                    <div class="text-green-600">No supporters for this family yet.</div>
                  @else
                  <div class="max-h-[250px] overflow-y-scroll w-full max-md:h-[400px] max-md:max-h-[400px]">
                  @foreach ($supporters as $supporter)
                    <div class="flex px-3 items-center w-full justify-between max-md:flex max-md:flex-col max-md:mx-auto max-md:w-full max-md:justify-center max-md:border-b-2">
                      <div class="relative py-5 pr-6 max-md:mx-auto">
                        <div class="flex gap-x-6 items-center">
                          @if ($user->avatar === null)
                            <span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100">
                              <svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                              </svg>
                            </span>
                          @else
                            <span class="relative inline-block">
                              <img class="h-8 w-8 rounded-full" src="{{ asset('storage/images/' . $user->avatar) }}" alt="">
                            </span>
                          @endif
                          <div class="flex-auto">
                            <div class="flex items-start gap-x-3">
                              <div class="text-sm font-medium leading-6 text-gray-900">{{ $supporter->name }}</div>
                              <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">{{ $supporter->account_id }}</div>
                            </div>
                            <div class="flex mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                              <p>Total paid amount:</p>
                              <p class="text-green-700 font-bold">{{ $supporter->pivot->support_amount }}.00 $</p>
                            </div>
                          </div>
                        </div>
                        <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100 max-md:hidden"></div>
                        <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100 max-md:hidden"></div>
                      </div>                      
                      @if ($supporter->website_url === null && $supporter->instagram_url === null && $supporter->linkedin_url === null && $supporter->twitter_url === null && $supporter->tiktok_url === null)
                        <div class="text-blue-700 flex px-5 py-8 items-center gap-x-4 max-md:w-full max-md:justify-center max-md:py-2">No links to social media</div>
                      @else
                      <div class="flex px-5 py-8 items-center gap-x-4 max-md:w-full max-md:justify-center max-md:py-2">
                        @if ($supporter->website_url)
                          <a href="{{ $supporter->website_url }}">
                            <svg stroke="currentColor" fill="blue" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M12,2C6.486,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.514,2,12,2z M4,12c0-0.899,0.156-1.762,0.431-2.569L6,11l2,2 v2l2,2l1,1v1.931C7.061,19.436,4,16.072,4,12z M18.33,16.873C17.677,16.347,16.687,16,16,16v-1c0-1.104-0.896-2-2-2h-4v-2v-1 c1.104,0,2-0.896,2-2V7h1c1.104,0,2-0.896,2-2V4.589C17.928,5.778,20,8.65,20,12C20,13.835,19.373,15.522,18.33,16.873z"></path></svg>
                          </a>
                        @endif
                        @if ($supporter->instagram_url)
                          <a href="{{ $supporter->instagram_url }}">
                            <svg stroke="#405DE6" fill="#833AB4" stroke-width="20px" viewBox="0 0 1024 1024" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M512 306.9c-113.5 0-205.1 91.6-205.1 205.1S398.5 717.1 512 717.1 717.1 625.5 717.1 512 625.5 306.9 512 306.9zm0 338.4c-73.4 0-133.3-59.9-133.3-133.3S438.6 378.7 512 378.7 645.3 438.6 645.3 512 585.4 645.3 512 645.3zm213.5-394.6c-26.5 0-47.9 21.4-47.9 47.9s21.4 47.9 47.9 47.9 47.9-21.3 47.9-47.9a47.84 47.84 0 0 0-47.9-47.9zM911.8 512c0-55.2.5-109.9-2.6-165-3.1-64-17.7-120.8-64.5-167.6-46.9-46.9-103.6-61.4-167.6-64.5-55.2-3.1-109.9-2.6-165-2.6-55.2 0-109.9-.5-165 2.6-64 3.1-120.8 17.7-167.6 64.5C132.6 226.3 118.1 283 115 347c-3.1 55.2-2.6 109.9-2.6 165s-.5 109.9 2.6 165c3.1 64 17.7 120.8 64.5 167.6 46.9 46.9 103.6 61.4 167.6 64.5 55.2 3.1 109.9 2.6 165 2.6 55.2 0 109.9.5 165-2.6 64-3.1 120.8-17.7 167.6-64.5 46.9-46.9 61.4-103.6 64.5-167.6 3.2-55.1 2.6-109.8 2.6-165zm-88 235.8c-7.3 18.2-16.1 31.8-30.2 45.8-14.1 14.1-27.6 22.9-45.8 30.2C695.2 844.7 570.3 840 512 840c-58.3 0-183.3 4.7-235.9-16.1-18.2-7.3-31.8-16.1-45.8-30.2-14.1-14.1-22.9-27.6-30.2-45.8C179.3 695.2 184 570.3 184 512c0-58.3-4.7-183.3 16.1-235.9 7.3-18.2 16.1-31.8 30.2-45.8s27.6-22.9 45.8-30.2C328.7 179.3 453.7 184 512 184s183.3-4.7 235.9 16.1c18.2 7.3 31.8 16.1 45.8 30.2 14.1 14.1 22.9 27.6 30.2 45.8C844.7 328.7 840 453.7 840 512c0 58.3 4.7 183.2-16.2 235.8z"></path></svg>
                          </a>
                        @endif
                        @if ($supporter->linkedin_url)
                          <a href="{{ $supporter->linkedin_url }}">
                            <svg stroke="currentColor" fill="#0A66C2" stroke-width="0" viewBox="0 0 1024 1024" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M880 112H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V144c0-17.7-14.3-32-32-32zM349.3 793.7H230.6V411.9h118.7v381.8zm-59.3-434a68.8 68.8 0 1 1 68.8-68.8c-.1 38-30.9 68.8-68.8 68.8zm503.7 434H675.1V608c0-44.3-.8-101.2-61.7-101.2-61.7 0-71.2 48.2-71.2 98v188.9H423.7V411.9h113.8v52.2h1.6c15.8-30 54.5-61.7 112.3-61.7 120.2 0 142.3 79.1 142.3 181.9v209.4z"></path></svg>
                          </a>
                        @endif
                        @if ($supporter->twitter_url)
                          <a href="{{ $supporter->twitter_url }}">
                            <svg stroke="currentColor" fill="#1DA1F2" stroke-width="0" viewBox="0 0 512 512" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                          </a>
                        @endif
                        @if ($supporter->tiktok_url)
                          <a href="{{ $supporter->tiktok_url }}" target="_blank">
                            <svg stroke="#00f2ea" fill="#ff0050" stroke-width="2" role="img" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><title></title><path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"></path></svg>
                          </a>
                        @endif
                        </div>
                      @endif
                      <div class="py-5 text-right max-md:w-full max-md:justify-center max-md:text-center">
                        <div class="flex justify-end max-md:justify-center">
                          <button class="text-sm font-medium leading-6 text-indigo-600 hover:text-indigo-500 view-quote-button"
                              data-user-id="{{ $supporter->id }}"
                              data-modal-target="quoteModal">
                            View {{ $supporter->name }} Quote
                          </button>
                        </div>
                      </div>
                    </div>
                  @endforeach
                  </div>
                  @endif
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex gap-x-12">
        <figure class="max-w-screen-md mx-auto text-center quote-container">
            <svg class="w-10 h-10 mx-auto mb-3 text-gray-400 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
                <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z"/>
            </svg>
            <blockquote>
                <p class="text-2xl italic font-medium text-gray-900 dark:text-gray-700 quote-content">"Flowbite is just awesome. It contains tons of predesigned components and pages starting from login screen to complex dashboard. Perfect choice for your next SaaS application."</p>
            </blockquote>
            <figcaption class="flex items-center justify-center mt-6 space-x-3">
                <div class="avatar-container dark:text-white"></div>
                <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700 name-container">
                    <cite class="pr-3 font-medium text-gray-900 dark:text-white">Micheal Gough</cite>
                </div>
            </figcaption>
        </figure>
      </div>    
    
    </div>
  </main>
@endsection
@push('script')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const viewQuoteButtons = document.querySelectorAll('.view-quote-button');
    const quoteModal = document.getElementById('quoteModal');
    const modalContent = document.getElementById('modalContent');

    viewQuoteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');

            // Send AJAX request to fetch user's quote
            fetch(`/get-user-quote/${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Construct the modal content
                    let content = `
                        <div class="px-4 text-center flex justify-start">
                            ${data.avatar ? `<img class="h-5 w-5 rounded-full" src="https://royalfamilynames.com/storage/images/${data.avatar}" alt="">` : '<span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100"><svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg></span>'}
                        </div>
                        <div class="mb-5 mt-5 text-lg font-normal text-gray-500 dark:text-gray-300 text-center">"${data.quote || 'User didn\'t added any quote'}"</div>
                    `;

                    // Conditionally add the user's name if quote is not null
                    if (data.quote) {
                        content += `<div class="w-full flex justify-end py-6 px-6 text-zinc-500">by ${data.name}</div>`;
                    }

                    // Set the modal content
                    modalContent.innerHTML = content;

                    // Show the modal
                    quoteModal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching user quote:', error);
                });
        });
    });

    const closeModalButton = document.querySelector('[data-modal-hide="quoteModal"]');
    closeModalButton.addEventListener('click', () => {
        // Hide the modal
        quoteModal.classList.add('hidden');
    });
});
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const quoteContainers = document.querySelectorAll('.quote-container');
    const quoteContents = document.querySelectorAll('.quote-content');
    const avatarContainers = document.querySelectorAll('.avatar-container');
    const nameContainers = document.querySelectorAll('.name-container');

    function getRandomUserId(familyUsers) {
        const randomIndex = Math.floor(Math.random() * familyUsers.length);
        return familyUsers[randomIndex].id;
    }
    function fetchAndDisplayQuotes(familyUsers) {
        for (let i = 0; i < quoteContainers.length; i++) {
            const userId = getRandomUserId(familyUsers);
            fetch(`/get-user-quote/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const content = data.quote;
                    const avatar = data.avatar ? `<img class="h-5 w-5 rounded-full" src="https://royalfamilynames.com/storage/images/${data.avatar}" alt="">` : '<span class="inline-block h-7 w-7 overflow-hidden rounded-full bg-gray-100"><svg class="h-full w-full text-gray-300" fill="blue" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg></span>';
                    const name = data.name;

                    if (content !== null && content !== '') {
                        quoteContents[i].innerHTML = `"${content}"`;
                        avatarContainers[i].innerHTML = avatar;
                        nameContainers[i].textContent = name;

                        quoteContainers[i].classList.add('show-quote');
                    } else {
                        // If quote is null or empty, hide the container
                        quoteContainers[i].classList.remove('show-quote');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user quote:', error);
                });
        }
    }
    const familyUsers = {!! json_encode($family->users) !!};

    fetchAndDisplayQuotes(familyUsers);

    setInterval(() => {
        for (const container of quoteContainers) {
            container.classList.remove('show-quote');
        }
        setTimeout(() => fetchAndDisplayQuotes(familyUsers), 500);
    }, 15000);
});
</script>
<script>
  // Wait for the DOM to load
  document.addEventListener('DOMContentLoaded', function() {
            // Simulate data fetching delay (you can remove this in your actual implementation)
            setTimeout(function() {
                // Hide the loading view and show the actual content
                document.querySelector('.loading').style.display = 'none';
                document.querySelector('#data-container').style.display = 'block';
            }, 1000); // Adjust the delay as needed
        });
</script>
@endpush