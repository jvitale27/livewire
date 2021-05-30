<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;


class ShowPosts extends Component
{
	use WithPagination;			//clase para paginar en Livewire

    public $search;					//propiedad que va a estar vinculada(cableada) al campo de busqueda
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = ['render1' => 'render'];     //escucho los eventos y ejecuto metodos
                                                        //render1 lo emite CreatePost
//    protected $listeners = ['render'];     //si el evento y el metodo se llaman igual solo pongo uno

    public function updatingSearch(){   //se ejecuta automaticamente cada vez que cambia la vble $search
        $this->resetPage();             //en cada busqueda vuelve a la pagina 1
    }

    public function render()
    {
    	$posts = Post::where('title', 'like', '%' . $this->search . '%')
    				->orWhere('content', 'like', '%' . $this->search . '%')
    				->orderBy($this->sort, $this->direction)
    				->paginate();


        return view('livewire.show-posts', compact('posts'));
    }

    public function order( $sort)
    {
    	if($this->sort == $sort)
    	{
    		if($this->direction == 'asc')
    			$this->direction = 'desc';
    		else
    			$this->direction = 'asc';
    	}
    	else
    	{
	   		$this->sort = $sort;
   			$this->direction == 'asc';
    	}
    }
}
