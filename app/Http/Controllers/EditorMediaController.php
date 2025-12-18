<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class EditorMediaController extends Controller
{
    public function upload(Request $request)
    {
        $fileKey = $request->hasFile('image') ? 'image' : 
                  ($request->hasFile('video') ? 'video' : 
                  ($request->hasFile('file') ? 'file' : null));

        if ($fileKey && $request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('editor', $fileName, 'public');
            
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset('storage/' . $path),
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize()
                ]
            ]);
        }

        return response()->json(['success' => 0]);
    }

    public function fetchLink(Request $request)
    {
        $url = $request->query('url');
        
        $meta = [
            'title' => 'Link Preview',
            'description' => $url,
            'image' => ['url' => ''],
            'site_name' => parse_url($url, PHP_URL_HOST)
        ];

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            $videoId = $this->getYoutubeId($url);
            $meta['title'] = 'YouTube Video';
            $meta['image']['url'] = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        } 
        elseif (str_contains($url, 'vimeo.com')) {
            $meta['title'] = 'Vimeo Video';
        }
        elseif (str_contains($url, 'instagram.com')) {
            $meta['title'] = 'Instagram Post';
        }
        elseif (str_contains($url, 'facebook.com')) {
            $meta['title'] = 'Facebook Post';
        }

        return response()->json([
            'success' => 1,
            'meta' => $meta
        ]);
    }

    private function getYoutubeId($url) 
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return $match[1];
        }
        return null;
    }
}