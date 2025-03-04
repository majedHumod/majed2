<?php

namespace App\Livewire\Subscriber;

use App\Models\BodyMeasurement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BodyMeasurementForm extends Component
{
    public $measurementId;
    public $date_recorded;
    public $weight;
    public $height;
    public $body_fat_percentage;
    public $chest;
    public $waist;
    public $hips;
    public $arms;
    public $thighs;
    public $calves;
    public $notes;
    
    public $isEditing = false;
    
    protected $rules = [
        'date_recorded' => 'required|date|before_or_equal:today',
        'weight' => 'required|numeric|min:20|max:500',
        'height' => 'nullable|numeric|min:50|max:300',
        'body_fat_percentage' => 'nullable|numeric|min:1|max:70',
        'chest' => 'nullable|numeric|min:20|max:200',
        'waist' => 'nullable|numeric|min:20|max:200',
        'hips' => 'nullable|numeric|min:20|max:200',
        'arms' => 'nullable|numeric|min:10|max:100',
        'thighs' => 'nullable|numeric|min:10|max:150',
        'calves' => 'nullable|numeric|min:10|max:100',
        'notes' => 'nullable|string|max:500',
    ];
    
    public function mount($measurementId = null)
    {
        $this->date_recorded = date('Y-m-d');
        
        if ($measurementId) {
            $this->measurementId = $measurementId;
            $this->isEditing = true;
            
            $measurement = BodyMeasurement::findOrFail($measurementId);
            
            // Ensure the measurement belongs to the current user
            if ($measurement->subscriber_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            
            $this->date_recorded = $measurement->date_recorded->format('Y-m-d');
            $this->weight = $measurement->weight;
            $this->height = $measurement->height;
            $this->body_fat_percentage = $measurement->body_fat_percentage;
            $this->chest = $measurement->chest;
            $this->waist = $measurement->waist;
            $this->hips = $measurement->hips;
            $this->arms = $measurement->arms;
            $this->thighs = $measurement->thighs;
            $this->calves = $measurement->calves;
            $this->notes = $measurement->notes;
        }
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->isEditing) {
            $measurement = BodyMeasurement::findOrFail($this->measurementId);
            
            // Ensure the measurement belongs to the current user
            if ($measurement->subscriber_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $measurement = new BodyMeasurement();
            $measurement->subscriber_id = Auth::id();
        }
        
        $measurement->date_recorded = $this->date_recorded;
        $measurement->weight = $this->weight;
        $measurement->height = $this->height;
        $measurement->body_fat_percentage = $this->body_fat_percentage;
        $measurement->chest = $this->chest;
        $measurement->waist = $this->waist;
        $measurement->hips = $this->hips;
        $measurement->arms = $this->arms;
        $measurement->thighs = $this->thighs;
        $measurement->calves = $this->calves;
        $measurement->notes = $this->notes;
        $measurement->save();
        
        session()->flash('message', $this->isEditing ? 'Measurement updated successfully.' : 'Measurement recorded successfully.');
        
        return redirect()->route('subscriber.progress');
    }
    
    public function render()
    {
        return view('livewire.subscriber.body-measurement-form')
            ->layout('components.layouts.app');
    }
}