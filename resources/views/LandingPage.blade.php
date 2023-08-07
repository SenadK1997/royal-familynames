@extends('layouts.master')

@section("title")

RoyalFamilyNames

@endsection

@section('content')

<ul role="list" class="divide-y divide-gray-100 w-full max-w-screen-sm">
  @php
    // Sort the $familynames array based on valuation in descending order
    $sortedFamilynames = $familynames->sortByDesc('valuation');
    $ranking = 1;
  @endphp
  @foreach ($sortedFamilynames as $index => $familyname)
      <li class="relative flex justify-between gap-x-6 py-5 cursor-pointer" id="familyItem{{ $ranking }}" data-family-code="{{ $familyname->family_code }}">
        <div class="flex gap-x-4 items-center">
          <span class="inset-x-0 -top-px bottom-0">{{ $ranking }}</span>
          <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-900">
              <a href="#" class="flex">
                {{ $familyname->family_name }}
              </a>
            </p>
            <p class="mt-1 flex text-xs leading-5 text-gray-500">
              <a href="mailto:leslie.alexander@example.com" class="relative truncate hover:underline">Overall Valuation:</a>
            </p>
          </div>
        </div>
        <div class="flex items-center gap-x-4">
          <div class="hidden sm:flex sm:flex-col sm:items-end">
            <p class="text-sm leading-6 text-gray-900">from {{ $familyname->country }}</p>
            <p class="mt-1 text-xs leading-5 text-green-500">{{ $familyname->valuation }}.00 $</p>
          </div>
          <img class="w-12 flex-none bg-gray-50 object-contain" src="{{ $familyname->flag_url }}" alt="">
          <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
          </svg>
        </div>
      </li>
  @php
    $ranking++; // Increment the ranking
  @endphp
  @endforeach
</ul>
@endsection
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const listItems = document.querySelectorAll('[id^="familyItem"]');
  listItems.forEach(item => {
    item.addEventListener('click', function() {
      const familyCode = this.getAttribute('data-family-code'); // Get the family code from the data-family-code attribute
      const url = '{{ route('familyPage', ['family_code' => '__familyCode__']) }}';
      const finalUrl = url.replace('__familyCode__', familyCode);
      window.location.href = finalUrl;
    });
  });
});
</script>
@endpush