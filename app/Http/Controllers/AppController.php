<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NgBuildService;


class AppController extends Controller
{
    public function index(NgBuildService $ng)
    {
        // Provide our service's assets as $ngAssets inside
        // of app.blade.php
        return view('app', ['ngAssets' => $ng->assets]);
    }
}
