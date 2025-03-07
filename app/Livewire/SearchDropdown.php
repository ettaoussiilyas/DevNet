<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResults = [];
    public $isSearching = false;

    public function updatedSearch()
    {
        $this->isSearching = true;
        
        if (strlen($this->search) < 2) {
            $this->searchResults = [];
            $this->isSearching = false;
            return;
        }

        // Search for users
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('skills', 'like', '%' . $this->search . '%')
            ->orWhere('programming_languages', 'like', '%' . $this->search . '%')
            ->orWhere('industry', 'like', '%' . $this->search . '%')
            ->take(5)
            ->get();

        // Search for posts
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('hashtags', 'like', '%' . $this->search . '%')
            ->take(5)
            ->get();

        // Combine results
        $this->searchResults = [
            'users' => $users,
            'posts' => $posts
        ];
        
        $this->isSearching = false;
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }
}
