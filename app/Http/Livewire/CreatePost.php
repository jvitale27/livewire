<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
	public $open = false;

	public $title;
	public $content;


	public function save()
	{
		Post::create([
			'title'   => $this->title,
			'content' => $this->content
		]);

		//reseteo todas las varibles. Se cierra el modal
		$this->reset(['open', 'title', 'content']);

		//emito un evento para que lo escuche el componente de livewire ShowPosts y actualice vista
//		$this->emit('render1');						//lo envio a todos los componente que lo escuchan 
		$this->emitTo('show-posts','render1');		//lo envio a un solo componente que lo escucha. en minuscula y con guiones
		//emito un evento que capturo en views/layouts/app.blade.php y muestre cartel de OK
		$this->emit('alert', 'El post fue creado con éxito');
	}

    public function render()
    {
        return view('livewire.create-post');
    }
}
