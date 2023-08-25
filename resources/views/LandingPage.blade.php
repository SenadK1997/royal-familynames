@extends('layouts.master')

@section("title")
RoyalFamilyNames
@endsection

@section('content')
<div class="w-full max-w-screen-sm h-full p-4">
    <img src="{{ asset('storage/images/longbanner2.png')}}" alt="" class="absolute w-[580px] h-[800px] top-13 left-[10%] px-2 ml-2 max-md:hidden max-[1400px]:hidden max-[1665px]:left-0 min-[1670px]:left-[6%] min-[2000px]:left-[12%] min-[2200px]:left-[17%]" style="opacity: 0.8">
    <img src="{{ asset('storage/images/longbanner2.png')}}" alt="" class="absolute w-[580px] h-[800px] top-13 right-[10%] px-2 mr-2 max-md:hidden max-[1400px]:hidden max-[1665px]:right-0 min-[1670px]:right-[6%] min-[2000px]:right-[12%] min-[2200px]:right-[17%]" style="opacity: 0.8">
    {{-- @php
      $sortedFamilynames = $familynames->sortByDesc('valuation');
      $ranking = 1;
    @endphp --}}
    @foreach ($familynames as $index => $familyname)
    <div class="relative flex justify-between gap-x-6 py-4 cursor-pointer" id="familyItem{{ $ranking }}"
        data-family-code="{{ $familyname->family_code }}">
        <div class="flex gap-x-4 items-center">
            {{-- <span class="inset-x-0 -top-px bottom-0 text-xl">{{ $ranking }}</span> --}}
            <span
                class="inset-x-0 -top-px bottom-0 text-xl {{ $ranking === 1 ? 'text-[#FFD700] font-bold text-[25px]' : ($ranking === 2 ? 'text-[#C0C0C0]' : ($ranking === 3 ? 'text-[#CD7F32]' : 'text-gray-800')) }}">
                {{ $ranking }}
            </span>
            <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-gray-900">
                    <a href="#" class="flex">
                        {{ $familyname->family_name }}
                    </a>
                </p>
                <p class="mt-1 flex text-xs leading-5 text-gray-500">
                    <p class="relative truncate hover:underline text-xs text-gray-500">Overall Valuation:</p>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-x-4">
            <div class="sm:flex sm:flex-col sm:items-end">
                <p class="text-sm leading-6 text-gray-900 max-md:hidden">{{ $familyname->country }}</p>
                <p class="mt-1 text-xs leading-5 text-green-500">{{ $familyname->valuation }}.00 $</p>
            </div>
            <img class="w-12 flex-none bg-gray-50 object-contain" src="{{ $familyname->flag_url }}" alt="">
            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    @php
    $ranking++; // Increment the ranking
    @endphp
    @endforeach
    {{ $familynames->links() }}
</div>
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
