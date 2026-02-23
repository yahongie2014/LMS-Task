<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageSwitcher extends Component
{
    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
            session()->save();
        }

        return redirect(url()->previous());
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
