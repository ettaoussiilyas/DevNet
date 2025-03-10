<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Post;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $users = [];
        $posts = [];
        
        if (strlen($this->search) >= 2) {
            $users = User::where('name', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
                
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
        }
        
        return view('livewire.search-dropdown', [
            'searchResults' => [
                'users' => $users,
                'posts' => $posts
            ]
        ]);
    }
}
