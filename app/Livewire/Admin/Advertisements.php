<?php

namespace App\Livewire\Admin;

use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Advertisements extends Component
{
    use WithPagination, WithFileUploads;
    
    public $title;
    public $description;
    public $image;
    public $image_url;
    public $link_url;
    public $position = 'sidebar';
    public $start_date;
    public $end_date;
    public $is_active = true;
    public $advertisementId;
    
    public $isEditing = false;
    public $isCreating = false;
    public $confirmingAdDeletion = false;
    public $adIdToDelete;
    
    public $searchTerm = '';
    public $positionFilter = '';
    public $statusFilter = '';
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:1024', // 1MB Max
        'image_url' => 'nullable|string|url',
        'link_url' => 'nullable|string|url',
        'position' => 'required|string|in:sidebar,banner,footer,popup',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'is_active' => 'boolean',
    ];
    
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }
    
    public function updatingPositionFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function create()
    {
        $this->reset(['title', 'description', 'image', 'image_url', 'link_url', 'position', 'start_date', 'end_date', 'advertisementId']);
        $this->is_active = true;
        $this->position = 'sidebar';
        $this->isCreating = true;
        $this->isEditing = false;
    }
    
    public function store()
    {
        $this->validate();
        
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'link_url' => $this->link_url,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
            'created_by' => Auth::id(),
        ];
        
        // Handle image upload if provided
        if ($this->image) {
            $imagePath = $this->image->store('advertisements', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        } elseif ($this->image_url) {
            $data['image_url'] = $this->image_url;
        }
        
        Advertisement::create($data);
        
        $this->reset(['title', 'description', 'image', 'image_url', 'link_url', 'position', 'start_date', 'end_date', 'advertisementId', 'isCreating']);
        $this->is_active = true;
        session()->flash('message', 'Advertisement created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $this->isCreating = false;
        $this->advertisementId = $id;
        
        $advertisement = Advertisement::findOrFail($id);
        
        $this->title = $advertisement->title;
        $this->description = $advertisement->description;
        $this->image_url = $advertisement->image_url;
        $this->link_url = $advertisement->link_url;
        $this->position = $advertisement->position;
        $this->start_date = $advertisement->start_date ? $advertisement->start_date->format('Y-m-d') : null;
        $this->end_date = $advertisement->end_date ? $advertisement->end_date->format('Y-m-d') : null;
        $this->is_active = $advertisement->is_active;
    }
    
    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024', // 1MB Max
            'image_url' => 'nullable|string',
            'link_url' => 'nullable|string|url',
            'position' => 'required|string|in:sidebar,banner,footer,popup',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);
        
        $advertisement = Advertisement::findOrFail($this->advertisementId);
        
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'link_url' => $this->link_url,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
        ];
        
        // Handle image upload if provided
        if ($this->image) {
            $imagePath = $this->image->store('advertisements', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        } elseif ($this->image_url) {
            $data['image_url'] = $this->image_url;
        }
        
        $advertisement->update($data);
        
        $this->reset(['title', 'description', 'image', 'image_url', 'link_url', 'position', 'start_date', 'end_date', 'advertisementId', 'isEditing']);
        $this->is_active = true;
        session()->flash('message', 'Advertisement updated successfully.');
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingAdDeletion = true;
        $this->adIdToDelete = $id;
    }
    
    public function deleteAdvertisement()
    {
        $advertisement = Advertisement::findOrFail($this->adIdToDelete);
        $advertisement->delete();
        
        $this->confirmingAdDeletion = false;
        session()->flash('message', 'Advertisement deleted successfully.');
    }
    
    public function cancelDelete()
    {
        $this->confirmingAdDeletion = false;
    }
    
    public function cancel()
    {
        $this->reset(['title', 'description', 'image', 'image_url', 'link_url', 'position', 'start_date', 'end_date', 'advertisementId', 'isEditing', 'isCreating']);
        $this->is_active = true;
    }
    
    public function toggleStatus($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->update([
            'is_active' => !$advertisement->is_active
        ]);
        
        session()->flash('message', 'Advertisement status updated successfully.');
    }
    
    public function render()
    {
        $query = Advertisement::query();
        
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        if ($this->positionFilter) {
            $query->where('position', $this->positionFilter);
        }
        
        if ($this->statusFilter !== '') {
            $isActive = $this->statusFilter === 'active';
            $query->where('is_active', $isActive);
        }
        
        $advertisements = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.admin.advertisements', [
            'advertisements' => $advertisements
        ])->layout('components.layouts.app');
    }
}