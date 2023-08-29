@extends('layouts.auth')

@section("title")

Forgot Password

@endsection
@section('content')
    <div class="flex mt-14 items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white py-8 px-6 shadow-md rounded-md">
                @if(session('error'))
                    <div class="alert alert-danger text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                <h2 class="text-2xl font-semibold mb-4">Reset Password</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required class="mt-1 px-4 py-2 w-full rounded-md border-gray-300">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required class="mt-1 px-4 py-2 w-full rounded-md border-gray-300">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 px-4 py-2 w-full rounded-md border-gray-300">
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
