<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class ShotController extends Controller
{
    public function index(Request $request)
    {
        $url = $request->input('url');
        $image_name = $request->input('image_name', 'screenshot.jpg');
        $width = $request->input('width', 1920);
        $height = $request->input('height', 1080);

        $obj = Browsershot::url($url)
            ->noSandbox()
            ->windowSize($width, $height)
            ->setChromePath("/usr/bin/chromium-browser");
        $messages = $obj->consoleMessages();
        $obj->save($image_name);
        return response(["messages" => $messages]);
    }
}
