@auth
@extends('layouts.master')

@section("title")

RoyalFamilyNames || {{ $family->family_name }}

@endsection

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm flex flex-col">
        <h2 class="gap-x-2 flex mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 mx-auto">
            Support
            <p class="text-blue-700">{{ $family->family_name }}</p>
            family
        </h2>
        <div class="flex w-full mx-auto text-red-500 justify-center text-lg font-bold">{{ $family->family_code }}</div>
    </div>
  
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="{{ route('supportFamily', ['family_code' => $family->family_code ]) }}" method="POST">
        @csrf
        <div>
          <label for="family_name" class="block text-sm font-medium leading-6 text-gray-900">Family name</label>
          @if(session('error'))
            <div class="alert alert-danger text-red-700">
                {{ session('error') }}
            </div>
          @endif
          <div class="mt-2">
            <input id="family_name" name="family_name" type="text" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" disabled value="{{ $family->family_name }}">
          </div>
        </div>
        <div>
            <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country origin</label>
            <div class="mt-2">
              <input id="country" name="country" type="text" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" disabled value="{{ $family->country }}">
            </div>
          </div>
  
        <div>
          <div class="flex items-center justify-between">
            <label for="valuation" class="block text-sm font-medium leading-6 text-gray-900">Amount</label>
          </div>
          <div class="mt-2">
            <input id="valuation" name="valuation" type="number" autocomplete="current-password" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
  
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register to {{ $family->family_name }}</button>
        </div>
      </form>
        <div class="mt-8 flex w-full mx-auto text-red-500 justify-center text-[10px] font-normal">
            Note: You will not become member of the family by supporting. If you want to become a member of the family, go to your account and register to existing family
        </div>
    </div>
  </div>
  
@endsection
@endauth