@extends('layouts.app')
@section('content')
   <x-modal id="modal-create"  size="2xl" center>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Create new article</h2>
        <p class="text-base text-gray-600 mb-6">
            Choose where to create your article. This will reflect on your KB site once you publish this article.
        </p>
        <livewire:document.article-create />
    </x-modal>

        <div>
            <livewire:document.article-show/>
        </div>

@endsection
