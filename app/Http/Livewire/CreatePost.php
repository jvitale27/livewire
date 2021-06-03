<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;		//para poder subir imagenes desde componente de Livewire

class CreatePost extends Component
{
	use WithFileUploads;			//para poder subir imagenes desde componente de Livewire

	public $open = false;			//muestra o no el componente de livewire de crear post

	public $title;
	public $content;
	public $image = null;
	public $identificador;		//solo creado para que se resetee y refresque el <input file> de la vista

	//asigno un valor a identificador para que se refresque y actualice el <input file> de la vista
	public function mount(){
		$this->identificador = rand();			//identificador aleatorio
	}

	//reglas de validacion de datos
	protected $rules = [
		'title'   => 'required|max:100',
		'content' => 'required|max:65530',
		'image'   => 'required|max:2048'		//2 MB
	];

	//si quisiera que las validaciones se hagan al mismo tiempo que estoy ingresando texto y no al final cuando guardo, debo agregar esta funcion que se va a ejecutar cada vez que cambie algo en una de las propiedades de esta clase. Ademas para que funcione debo quitar el .defer del wire:model de los objetos que linkean a las propiedades
	/*public function updated( $propertyName)
	{
		$this->validateOnly( $propertyName);	//solo valida la propiedad que estoy modificando
	}*/


	public function save()
	{
		$this->validate();			//validacion de datos segun las reglas establecidas

		$image = $this->image->store('posts');	//guardo imagen en posts/{image}

		//si hay una imagen ya seleccionada, deberia borar la imagen o la carpeta temporaria de livewire que es public/storage/livewire-tmp/, aunque este link $this->image->temporaryUrl() apunta a http://livewire.test/livewire/preview-file/, en fin
		//Storage::delete( $this->image->temporaryUrl());	no funciono por el link
		//entonce borro la carpeta public/storage/livewire-tmp donde almaceno imagenes temporarias
		Storage::deleteDirectory('livewire-tmp');	// OJO!!! si hay multiusuarios esto esta mal. No borrar la carpeta

		Post::create([
			'title'   => $this->title,
			'content' => $this->content,
			'image'   => $image 				//guardo posts/{image}
		]);

		//reseteo todas las varibles. Se cierra el modal
		$this->reset(['open', 'title', 'content', 'image']);

		//asigno un valor a identificador para que se refresque y actualice el <input file> de la vista
		$this->identificador = rand();			//identificador aleatorio

		//emito un evento para que lo escuche el componente de livewire ShowPosts y actualice vista
//		$this->emit('render1');						//lo envio a todos los componente que lo escuchan 
		$this->emitTo('show-posts','render1');		//lo envio a un solo componente que lo escucha. en minuscula y con guiones
		//emito un evento que capturo en views/layouts/app.blade.php y muestre cartel de OK
		$this->emit('CartelExito', 'Guardado!', 'El post fue creado con éxito');

	}

    public function render()
    {
        return view('livewire.create-post');
    }
}
