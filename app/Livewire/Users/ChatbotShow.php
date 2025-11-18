<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Team;
use App\Models\Chatbot;
use Illuminate\Support\Facades\Auth;

class ChatbotShow extends Component
{
    public ?Team $team = null;
    public ?Chatbot $chatbot = null;

    public $spaces = [];
    public $user;
    public $comments = [];
    public $commentsCount = 0;
    public $commentStatuses = [];

    protected $listeners = ['showChatbot'];

    public function mount(?Team $team = null, ?Chatbot $chatbot = null)
    {
        $this->user = Auth::user();

        if ($team && $chatbot) {
            $this->loadChatbot($team, $chatbot);
        }

        $this->commentStatuses = $this->getNotaPKPStatuses();
    }

    public function showChatbot($chatbotId)
    {
        $chatbot = Chatbot::with(['team', 'organisation.ministry', 'organisation.department', 'comments.user'])
            ->findOrFail($chatbotId);

        $this->loadChatbot($chatbot->team, $chatbot);
    }

    protected function loadChatbot(Team $team, Chatbot $chatbot)
    {
        $this->team = $team;
        $this->chatbot = $chatbot;

        // Load spaces
        $this->spaces = $team->spaces ?? [];

        // Load comments
        $this->comments = $chatbot->comments()->with('user')->get();
        $this->commentsCount = $this->comments->count();

        // Track views once per session
        $key = 'wiki_chatbot_viewed_' . $chatbot->id;
        if (!session()->has($key)) {
            $chatbot->increment('views'); // or your updatewikiChatbotView()
            session([$key => true]);
        }
    }

    public function getRegionName($id)
    {
        $regions = [
            1 => 'Semenanjung',
            2 => 'Sabah',
            3 => 'Sarawak',
        ];

        return $regions[$id] ?? 'N/A';
    }

    public function getLanguageName($id)
    {
        $languages = [
            1 => 'BM',
            2 => 'EN',
        ];

        return $languages[$id] ?? 'N/A';
    }

    protected function commentToDoStatus() { return 'To Do'; }
    protected function commentDoingStatus() { return 'Doing'; }
    protected function commentDoneStatus() { return 'Done'; }

    protected function getNotaPKPStatuses(): array
    {
        return [
            $this->commentToDoStatus(),
            $this->commentDoingStatus(),
            $this->commentDoneStatus(),
        ];
    }

    public function render()
    {
        return view('livewire.users.chatbot-show');
    }
}
