<?php

namespace App\Livewire\Organisation\Articles;

use Livewire\Component;
use App\Models\Wiki;
use App\Models\Organisation;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleCreate extends Component
{
    use Interactions;

    public $name = '';
    public $description = '';
    public $organisation_id;

    public $organisations_list = [];

    // Listen for modal open
    protected $listeners = ['open-modal-create-article' => 'openModal'];

    public function mount()
    {
        $this->organisations_list = Organisation::all()->map(function($org) {
            return [
                'value' => $org->id,
                'label' => $org->name,
            ];
        })->toArray();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'required|string|max:255|unique:wiki,name',
            'description' => 'nullable|string',
            'organisation_id' => 'required|exists:organisations,id',
        ]);
    }

    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:wiki,name',
            'description' => 'nullable|string',
            'organisation_id' => 'required|exists:organisations,id',
        ]);

        Wiki::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'description' => $validatedData['description'] ?? '',
            'organisation_id' => $validatedData['organisation_id'],
            'wiki_type' => 'article',
            'user_id' => Auth::id(),
        ]);

        $this->toast()->success('Success', 'Article created successfully')->send();
        $this->dispatch('close-modal-create-article');
        $this->reset(['name', 'description', 'organisation_id']);
        $this->dispatch('refresh-article-list');
    }

    public function render()
    {
        return view('livewire.organisation.articles.article-create');
    }
}
