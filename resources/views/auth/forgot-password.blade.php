@extends('layouts.master')

@section("title")

Forgot Password

@endsection

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 mt-20 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Forgot Password</h2>
    </div>
      @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
       @endif
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            @if ($errors->has('email'))
                <div class="text-red-700 text-sm">{{ $errors->first('email') }}</div>
            @endif
            <input id="email" name="email" type="email" autocomplete="email" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-200">
          </div>
        </div>
        <div class="mt-2">
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Reset password</button>
        </div>
      </form>
  
    </div>
</div>
@endsection