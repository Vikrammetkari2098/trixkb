<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Chatbot;

class ChatbotAuditTrail extends Component
{
    public Chatbot $chatbot;
    public $user;

    public function mount(Chatbot $chatbot)
    {
        $this->chatbot = $chatbot;
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.users.chatbot-audit-trail');
    }
}
