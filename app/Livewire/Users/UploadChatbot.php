<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WikiUpload;
use App\Models\Team;
use App\Models\User;
use App\Services\SpaceService;
use TallStackUi\Traits\Interactions;

class UploadChatbot extends Component
{
    use WithFileUploads, Interactions;

    public $file;
    public Team $team;
    public User $user;
    public $wikiUpload = [];
    public $spaces = [];
    public $fileChosen = false;

    protected $listeners = ['refreshUpload' => '$refresh'];

    public function mount(Team $team, User $user, SpaceService $space)
    {
        $this->team = $team;
        $this->user = $user;
        $this->refreshUploads();
        $this->spaces = $space->getTeamSpaces($team->id);
    }

    public function uploadChatbotFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $path = $this->file->store('chatbot_uploads', 'public');

        // Using Eloquent instead of raw DB
        WikiUpload::create([
            'user_id'    => $this->user->id,
            'type'       => 'chatbot',
            'filename'   => $this->file->getClientOriginalName(),
            'space_id'   => null,
            'space_name' => null,
        ]);

        $this->refreshUploads();
        $this->reset('file');
        $this->fileChosen = false;

        $this->toast()->success('Success', 'Chatbot file uploaded successfully!')->send();
    }

    public function refreshUploads()
    {
        // Eloquent with relation
        $this->wikiUpload = WikiUpload::with('user')
            ->where('type', 'chatbot')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.users.upload-chatbot', [
            'wikiUpload' => $this->wikiUpload,
            'spaces'     => $this->spaces,
        ]);
    }
}
