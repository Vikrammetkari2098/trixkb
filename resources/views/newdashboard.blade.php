@extends('layouts.app')
@section('content')
<div class="aside-content p-4 bg-gray-50 rounded-lg shadow-sm">
    <div class="mb-6">
        <form class="space-y-4" id="list-search-form">
               <!-- Toggle Switch -->
            <div class="text-center">
                <label class="inline-flex items-center cursor-pointer">
                <span class="mr-3 text-sm font-medium text-gray-700">DIRECTORY</span>
                <div class="relative">
                    <input type="checkbox" id="wikiType_checkbox" name="wiki_type_filter" value="article" class="sr-only">
                    <div class="w-14 h-7 bg-gray-200 rounded-full transition dark:bg-gray-700 toggle-bg">
                    <div class="absolute left-0.5 top-0.5 bg-white border border-gray-300 rounded-full h-6 w-6 transition-transform transform translate-x-0 toggle-button"></div>
                    </div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-700">ARTICLE</span>
                </label>
            </div>

                  <!-- Ministry Dropdown -->
        <livewire:organisation-filters />
        </form>
    </div>

      <!-- Latest Articles Panel -->
    <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-green-500 px-4 py-2">
        <h3 class="text-white font-medium">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <a href="#" class="text-white hover:underline">Latest Articles</a>
        </h3>
        </div>
        <div class="p-0">
        <!-- Content will be populated dynamically -->
        <div class="p-4 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="mt-2">Nothing found</p>
        </div>
        </div>
    </div>

     <!-- Popular Articles and Directory Panel -->
    <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-700 px-4 py-2">
            <h3 class="text-white font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                </svg>
                <a href="#" class="text-white hover:underline">Popular Article and Directory</a>
            </h3>
        </div>
        <div class="p-0">
             <!-- Content will be populated dynamically -->
            <div class="p-4 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="mt-2">Nothing found</p>
            </div>
        </div>
    </div>

     <!-- Latest Infoblast Panel -->
    <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-green-500 px-4 py-2">
                <h3 class="text-white font-medium">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <a href="#" class="text-white hover:underline">Latest Infoblast</a>
                </h3>
            </div>
        <div class="p-0">
              <!-- Content will be populated dynamically -->
        <div class="p-4 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="mt-2">Nothing found</p>
        </div>
        </div>
    </div>

        <!-- Favourite Article and Directory Panel -->
    <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-pink-600 px-4 py-2 relative">
            <h3 class="text-white font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Favourite Article and Directory
            </h3>
        </div>
        <div class="p-0">
                <!-- Content will be populated dynamically -->
            <div class="p-4 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="mt-2">Nothing found</p>
            </div>
        </div>
    </div>

        <!-- Activities Panel -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-orange-500 px-4 py-2">
            <h3 class="text-white font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Activities
            </h3>
        </div>
        <div class="p-0">
            <!-- Content will be populated dynamically -->
            <div class="p-4 text-center text-gray-500">
                Activities content will appear here
            </div>
        </div>
    </div>
</div>

<style>
  /* Toggle switch styling */
  input:checked ~ .toggle-bg {
    background-color: #3B82F6;
  }
  input:checked ~ .toggle-bg .toggle-button {
    transform: translateX(1.75rem);
  }
</style>
@endsection
<style>
	.item:hover {
		background-color: #808080;
	}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  {{--    $(document).ready(function() {
		var selectedWikiType = 'article';
        $('#wikiType_checkbox').change(function() {
            selectedWikiType = $(this).is(':checked') ? 'article' : 'directory';
            var newUrlPath;

            if (selectedWikiType === 'article') {
                newUrlPath = "{{ route('users.wikies', [':teamSlug', ':userSlug']) }}";
            } else {
                newUrlPath = "{{ route('users.directory', [':teamSlug', ':userSlug']) }}";
            }

            newUrlPath = newUrlPath.replace(':teamSlug', '{{ $team->slug }}').replace(':userSlug', '{{ Auth::user()->slug }}');
            $('#list-search-form').attr('action', newUrlPath);
        });

		$(document).on('change', '.ajaxMinistryFilter', function (e)
        {
			if (selectedWikiType === 'article') {
                newUrlPath = "{{ route('users.wikies', [':teamSlug', ':userSlug']) }}";
            } else {
                newUrlPath = "{{ route('users.directory', [':teamSlug', ':userSlug']) }}";
            }

            newUrlPath = newUrlPath.replace(':teamSlug', '{{ $team->slug }}').replace(':userSlug', '{{ Auth::user()->slug }}');
            $('#list-search-form').attr('action', newUrlPath);
			$('#list-search-form').submit();
		});

    });

	function clearFilter()
	{
		$("#ministry_filter").val(null).trigger("change");
		$("#department_filter").val(null).trigger("change");
		$("#segment_filter").val(null).trigger("change");
		$("#unit_filter").val(null).trigger("change");
		$("#sub_unit_filter").val(null).trigger("change");
		$("#art_category_filter").val(null).trigger("change");
		$("#wikiType_filter").val($("#wikiType_filter option:first").val());
		$("#search-content").val("");
	}

	document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("list-search-form").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("list-search-form").submit();
            }
        });
    }); --}}
</script>
