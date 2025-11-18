<?php

namespace App\Livewire\Organisation;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MatrixUpload extends Component
{
    use WithFileUploads;

    public $uploadScriptFile;

    public function upload()
    {
        $this->validate([
            'uploadScriptFile' => 'required|file|max:512|mimes:xlsx,csv,txt,pdf',
        ]);

        $user = Auth::user();

        $path = $this->uploadScriptFile->store('matrix_uploads', 'public');

        // Dispatch toast
        $this->dispatch('toast', message: 'Matrix file uploaded successfully! ✅');

        // Reset file input
        $this->reset('uploadScriptFile');
    }

    public function render()
    {
        return view('livewire.organisation.matrix-upload');
    }
}
