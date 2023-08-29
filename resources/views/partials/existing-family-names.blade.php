<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.cdnfonts.com/css/futura-pt" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="mb-4">
    <label for="family" class="block text-sm font-medium text-gray-700">Existing families</label>
    <div class="relative mt-1">
      <form autocomplete="off" action="{{ route('register.existing', ['family_code' => ':family_code']) }}" id="familyForm" method="GET">
        @csrf
        <input type="hidden" value="">
        <input id="family" name="family" type="text" class="form-input px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Search from existing families">
        <div id="familyDropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden overflow-y-scroll">
          <!-- Options will be added here dynamically -->
        </div>
        <button class="w-full rounded-md bg-green-500 px-3 py-2 mt-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Submit</button>
      </form>
    </div>
</div>
</body>
@stack('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
<script>
  const familyForm = document.getElementById('familyForm');
  const familyInput = document.getElementById('family');
  const familyDropdown = document.getElementById('familyDropdown');
  const families = @json($families); // Convert PHP array to JavaScript array

  function updateFamilyDropdown(filteredFamilies) {
    familyDropdown.innerHTML = '';
    filteredFamilies.forEach(family => {
      const option = document.createElement('div');
      option.classList.add('cursor-pointer', 'py-2', 'px-3', 'hover:bg-gray-100');

      const familyNameElement = document.createElement('span');
      familyNameElement.textContent = family.family_name;
      familyNameElement.classList.add('block', 'text-sm', 'font-medium', 'text-gray-900');

      const familyCodeElement = document.createElement('span');
      familyCodeElement.textContent = family.family_code;
      familyCodeElement.classList.add('block', 'text-xs', 'text-gray-500');

      option.appendChild(familyNameElement);
      option.appendChild(familyCodeElement);

      option.addEventListener('click', function() {
        familyInput.value = family.family_name + ' ' + 'from' + ' ' + family.country;
        // familyForm.action = `{{ route('register.existing', ['family_code' => ':family_code']) }}`.replace(':family_code', family.family_code);
        familyForm.action = `{{ route('register.existing', ['family_code' => '']) }}/${family.family_code}`;
        familyDropdown.classList.add('hidden');
      });
      familyDropdown.appendChild(option);
    });
    familyDropdown.classList.remove('hidden');
  }

  familyInput.addEventListener('focus', function() {
    updateFamilyDropdown(families);
  });

  familyInput.addEventListener('input', function() {
    const searchQuery = familyInput.value.toLowerCase().trim();

    if (searchQuery.length === 0) {
      updateFamilyDropdown(families);
      return;
    }

    const filteredFamilies = families.filter(family => {
      return family.family_name.toLowerCase().includes(searchQuery);
    });

    updateFamilyDropdown(filteredFamilies);
  });

  // Close the dropdown when clicking outside
  document.body.addEventListener('click', function(event) {
    if (!familyDropdown.contains(event.target) && event.target !== familyInput) {
      familyDropdown.classList.add('hidden');
    }
  });
</script>
</html>