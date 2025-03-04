<?php

namespace App\Livewire\Trainer;

use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{
    use WithPagination;
    
    public $title;
    public $content;
    public $subscriber_id;
    public $is_private = true;
    public $noteId;
    
    public $isEditing = false;
    public $isCreating = false;
    public $confirmingNoteDeletion = false;
    public $noteIdToDelete;
    
    public $searchTerm = '';
    public $subscriberFilter = '';
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'subscriber_id' => 'nullable|exists:users,id',
        'is_private' => 'boolean',
    ];
    
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }
    
    public function updatingSubscriberFilter()
    {
        $this->resetPage();
    }
    
    public function create()
    {
        $this->reset(['title', 'content', 'subscriber_id', 'noteId']);
        $this->is_private = true;
        $this->isCreating = true;
        $this->isEditing = false;
    }
    
    public function store()
    {
        $this->validate();
        
        Note::create([
            'trainer_id' => Auth::id(),
            'subscriber_id' => $this->subscriber_id,
            'title' => $this->title,
            'content' => $this->content,
            'is_private' => $this->is_private,
        ]);
        
        $this->reset(['title', 'content', 'subscriber_id', 'noteId', 'isCreating']);
        $this->is_private = true;
        session()->flash('message', 'Note created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $this->isCreating = false;
        $this->noteId = $id;
        
        $note = Note::findOrFail($id);
        
        // Ensure the note belongs to the current trainer
        if ($note->trainer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $this->title = $note->title;
        $this->content = $note->content;
        $this->subscriber_id = $note->subscriber_id;
        $this->is_private = $note->is_private;
    }
    
    public function update()
    {
        $this->validate();
        
        $note = Note::findOrFail($this->noteId);
        
        // Ensure the note belongs to the current trainer
        if ($note->trainer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $note->update([
            'title' => $this->title,
            'content' => $this->content,
            'subscriber_id' => $this->subscriber_id,
            'is_private' => $this->is_private,
        ]);
        
        $this->reset(['title', 'content', 'subscriber_id', 'noteId', 'isEditing']);
        $this->is_private = true;
        session()->flash('message', 'Note updated successfully.');
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingNoteDeletion = true;
        $this->noteIdToDelete = $id;
    }
    
    public function deleteNote()
    {
        $note = Note::findOrFail($this->noteIdToDelete);
        
        // Ensure the note belongs to the current trainer
        if ($note->trainer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $note->delete();
        
        $this->confirmingNoteDeletion = false;
        session()->flash('message', 'Note deleted successfully.');
    }
    
    public function cancelDelete()
    {
        $this->confirmingNoteDeletion = false;
    }
    
    public function cancel()
    {
        $this->reset(['title', 'content', 'subscriber_id', 'noteId', 'isEditing', 'isCreating']);
        $this->is_private = true;
    }
    
    public function render()
    {
        $query = Note::where('trainer_id', Auth::id());
        
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        if ($this->subscriberFilter) {
            $query->where('subscriber_id', $this->subscriberFilter);
        }
        
        $notes = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $subscribers = User::where('role', 'subscriber')
            ->whereIn('id', Auth::user()->subscribers()->pluck('users.id'))
            ->orderBy('name')
            ->get();
        
        return view('livewire.trainer.notes', [
            'notes' => $notes,
            'subscribers' => $subscribers,
        ])->layout('components.layouts.app');
    }
}