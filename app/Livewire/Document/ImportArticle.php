<?php

namespace App\Livewire\Document;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ArticlesImport;
use TallStackUi\Traits\Interactions;

class ImportArticle extends Component
{
    use WithFileUploads, Interactions;

    public $file;
    public bool $modalImport = false;

    #[On('open-import-modal')]
    public function openModal()
    {
        $this->reset(['file', 'modalImport']);
        $this->modalImport = true;
    }

    public function downloadTemplate()
    {
        return response()->streamDownload(function () {
            echo "title,content,status\nExample Title,This is content,Published";
        }, 'import-template.csv');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240',
        ]);

        try {
            Excel::import(new ArticlesImport, $this->file);

            $this->modalImport = false;
            $this->toast()->success('Success', 'Articles imported successfully.')->send();
            
            $this->dispatch('refresh-articles-list');

        } catch (\Exception $e) {
            $this->toast()->error('Error', 'Import failed: ' . $e->getMessage())->send();
        }
    }

    public function render()
    {
        return view('livewire.document.import-article');
    }
}