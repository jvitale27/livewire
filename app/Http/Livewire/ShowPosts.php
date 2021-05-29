<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;


class ShowPosts extends Component
{
	use WithPagination;			//clase para paginar en Livewire

    public $search;					//propiedad que va a estar vinculada(cableada) al campo de busqueda

    public function updatingSearch(){   //se ejecuta automaticamente cada vez que cambia la vble $search
        $this->resetPage();             //en cada busqueda vuelve a la pagina 1
    }

    public function render()
    {
    	$posts = Post::where('title', 'like', '%' . $this->search . '%')
    				->orWhere('content', 'like', '%' . $this->search . '%')
    				->paginate();


        return view('livewire.show-posts', compact('posts'));
    }
}
