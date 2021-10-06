<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DownloadBookController extends Controller
{
    public function __invoke()
    {
        Gate::authorize('get-book');

        return Storage::download('javascript-eloquente-2-edição.pdf');
    }
}
