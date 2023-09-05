@extends('layouts.master')

@section('content')
<div class="h-full flex items-center justify-center mt-12">
    <div class="bg-white p-8 shadow-lg rounded-lg max-w-md">
        <h1 class="text-2xl font-semibold mb-4">Terms and Agreements</h1>
        <p class="text-gray-700 mb-4">
            By using our website, you agree to the following terms and conditions:
        </p>
        <ol class="list-decimal ml-6 text-gray-600">
            <li class="mb-2">You agree with storing your name and family name.</li>
            <li class="mb-2">You agree with contributing money to buy a place for your family name to be shown.</li>
            <!-- Add more terms and conditions as needed -->
        </ol>
    </div>
</div>
@endsection
