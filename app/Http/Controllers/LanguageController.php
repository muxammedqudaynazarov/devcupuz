<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($code)
    {
        $language = Language::where('locale', $code)->where('status', '1')->first();
        if ($language) {
            Session::put('locale', $code);
            Session::save();
            App::setLocale($code);
        }
        return redirect()->back();
    }
}
