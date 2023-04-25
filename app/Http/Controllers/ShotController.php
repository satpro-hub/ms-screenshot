<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShotController extends Controller
{
    public function index()
    {
        return response(["result" => "ok"]);
    }
}
