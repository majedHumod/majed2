<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;
    
    public $name;
    public $email;
    public $password;
    public $role = 'subscriber';
    public $userId;
    
    public $searchTerm = '';
    public $roleFilter = '';
    public $isEditing = false;
    public $confirmingUserDeletion = false;
    public $userIdToDelete;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,trainer,subscriber',
    ];
    
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }
    
    public function updatingRoleFilter()
    {
        $this->resetPage();
    }
    
    public function create()
    {
        $this->validate();
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);
        
        $this->reset(['name', 'email', 'password', 'role']);
        session()->flash('message', 'User created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $this->userId = $id;
        
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
    }
    
    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'role' => 'required|in:admin,trainer,subscriber',
            'password' => 'nullable|min:8',
        ]);
        
        $user = User::findOrFail($this->userId);
        
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
        
        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }
        
        $user->update($userData);
        
        $this->reset(['name', 'email', 'password', 'role', 'userId']);
        $this->isEditing = false;
        session()->flash('message', 'User updated successfully.');
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingUserDeletion = true;
        $this->userIdToDelete = $id;
    }
    
    public function deleteUser()
    {
        $user = User::findOrFail($this->userIdToDelete);
        $user->delete();
        
        $this->confirmingUserDeletion = false;
        session()->flash('message', 'User deleted successfully.');
    }
    
    public function cancelDelete()
    {
        $this->confirmingUserDeletion = false;
    }
    
    public function cancel()
    {
        $this->reset(['name', 'email', 'password', 'role', 'userId']);
        $this->isEditing = false;
    }
    
    public function render()
    {
        $query = User::query();
        
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.admin.user-management', [
            'users' => $users
        ])->layout('components.layouts.app');
    }
}