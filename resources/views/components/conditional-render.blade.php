@props(['condition', 'loadingMessage' => 'Loading...'])

@if($condition)
    {{ $slot }}
@else
    <div class="text-center py-4">
        <p class="text-gray-500">{{ $loadingMessage }}</p>
    </div>
@endif
