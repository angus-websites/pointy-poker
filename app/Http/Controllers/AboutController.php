<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function privacyPolicy(Request $request): Factory|View
    {

        $markdown = File::get(resource_path('markdown/privacy.md'));

        return view('public.privacy-policy', [
            'markdown' => Str::markdown($markdown),
        ]);
    }
}
