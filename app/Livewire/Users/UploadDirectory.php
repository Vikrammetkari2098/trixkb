<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\User;
use App\Services\SpaceService;
use TallStackUi\Traits\Interactions;

class UploadDirectory extends Component
{
    use WithFileUploads, Interactions;

    // Public properties
    public $file; // single uploaded file
    public $wikiUpload = [];
    public $spaces = [];
    public Team $team;
    public User $user;

    // Optional: Alpine.js or Livewire reactivity
    public $fileChosen = false;

    // Listeners
    protected $listeners = ['refreshUpload' => '$refresh'];

    /**
     * Mount the component
     */
    public function mount(Team $team, User $user, SpaceService $space)
    {
        $this->team = $team;
        $this->user = $user;

        // Fetch initial uploads for this team
        $this->refreshUploads();

        // Fetch spaces for the team
        $this->spaces = $space->getTeamSpaces($team->id);

        // Update notifications if necessary
        $this->updateUploadNoti([13, 14]);
    }

    /**
     * Handle file upload
     */
    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240', // max 10MB
        ]);

        // Store the uploaded file in public storage
        $path = $this->file->store('uploads', 'public');

        // Insert record into wiki_upload table
        DB::table('wiki_upload')->insert([
            'user_id' => $this->user->id,
            'type' => 'directory',
            'filename' => $this->file->getClientOriginalName(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Refresh the upload list
        $this->refreshUploads();

        // Reset the file input
        $this->reset('file');
        $this->fileChosen = false;

        // Show success toast
        $this->toast()->success('Success', 'File uploaded successfully!')->send();
    }

    /**
     * Refresh the list of uploaded files
     */
    public function refreshUploads()
    {
        $this->wikiUpload = DB::table('wiki_upload as A')
            ->leftJoin('users as B', 'A.user_id', '=', 'B.id')
            ->select('A.*', 'B.name as user_name')
            ->where('A.type', 'directory')
            ->orderBy('A.created_at', 'desc')
            ->get();
    }

    /**
     * Example: update notifications
     */
    private function updateUploadNoti(array $types)
    {
        // Example logic for marking notifications as read
        // DB::table('notifications')->where('user_id', $this->user->id)->whereIn('type', $types)->update(['read' => 1]);
    }

    /**
     * Render the component view
     */
    public function render()
    {
        return view('livewire.users.upload-directory', [
            'wikiUpload' => $this->wikiUpload,
            'spaces' => $this->spaces,
        ]);
    }
}
