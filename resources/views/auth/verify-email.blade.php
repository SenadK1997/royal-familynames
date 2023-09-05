@extends('layouts.master')

@section('content')
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200 dark:border-gray-700">
            <p class="text-2xl text-gray-600">
                Before proceeding, please check your email for a verification link.
                If you did not receive the email,
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="underline-btn text-blue-400">
                        Click here to request another
                    </button>
                </form>
            </p>
        </div>
    </div>
@endsection