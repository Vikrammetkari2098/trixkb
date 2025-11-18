<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\WikiUpload;
class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function getTickets()
    {
        return view('users.tickets');
    }
       public function notaPKP()
    {
        return view('users.notaPKP');
    }
    public function getUpload(Team $team, User $user)
    {
        $directoryCount = WikiUpload::where('type', 'directory')->count();
        return view('users.upload-directory', compact('team', 'user','directoryCount'));
    }
    public function getUploadChatbot(Team $team, User $user)
    {
          $chatbotCount = WikiUpload::where('type', 'chatbot')->count();
        return view('users.upload-chatbot', compact('team', 'user','chatbotCount'));
    }
}



