<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Chatbot;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    // For user-specific chatbot listing
    public function showUserChatbot(Team $team, User $user)
    {
        $chatbots = $team->chatbots()->latest()->get();
        $chatbotCount = $chatbots->count();

        return view('chatbot.index', compact('team', 'user', 'chatbots', 'chatbotCount'));
    }

    // For a single chatbot details page
    public function showChatbot(Team $team, Chatbot $chatbot)
    {

        return view('chatbot.show', compact('team', 'chatbot'));
    }
}
