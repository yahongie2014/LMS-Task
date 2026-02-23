<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class IntroPopup extends Component
{
    public $show = false;
    public $type;
    public $media;

    public function mount()
    {
        $enabled = Setting::getValue('intro_enabled');
        
        if ($enabled && !session()->has('intro_shown')) {
            $this->show = true;
            $this->type = Setting::getValue('intro_type');
            
            if ($this->type === 'image') {
                $this->media = \Storage::disk('public')->url(Setting::getValue('intro_image'));
            } elseif ($this->type === 'youtube') {
                $this->media = Setting::getValue('intro_youtube_link');
            } elseif ($this->type === 'video') {
                $this->media = \Storage::disk('public')->url(Setting::getValue('intro_custom_video'));
            }
            
            session()->put('intro_shown', true);
        }
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.intro-popup');
    }
}
