<?php

namespace App\Livewire\Components;

use App\Models\Advertisement;
use Livewire\Component;

class DisplayAdvertisement extends Component
{
    public $position;
    public $advertisement;
    
    public function mount($position = 'sidebar')
    {
        $this->position = $position;
        $this->loadAdvertisement();
    }
    
    public function loadAdvertisement()
    {
        // Get a random active advertisement for the specified position
        $this->advertisement = Advertisement::active()
            ->position($this->position)
            ->inRandomOrder()
            ->first();
        
        // Increment impressions if an ad was found
        if ($this->advertisement) {
            $this->advertisement->incrementImpressions();
        }
    }
    
    public function trackClick()
    {
        if ($this->advertisement) {
            $this->advertisement->incrementClicks();
        }
    }
    
    public function render()
    {
        return view('livewire.components.display-advertisement');
    }
}