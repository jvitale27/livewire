<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;       //para poder subir imagenes desde componente de Livewire


class ShowPosts extends Component
{
	use WithPagination;			//clase para paginar en Livewire

    public $search;					//propiedad que va a estar vinculada(cableada) al campo de busqueda
    public $sort = 'id';
    public $direction = 'desc';

/*=============================================
=            Section comment block            =
=============================================*/
//para el caso de NO utilizar componentes de anidamiento y hacer la edicion de post en este componente
    use    WithFileUploads;            //para poder subir imagenes desde componente de Livewire
    public $post;
    public $open_edit = false;
    public $image = null;
    public $identificador;      //solo creado para que se resetee y refresque el <input file> de la vista

    //asigno un valor a identificador para que se refresque y actualice el <input file> de la vista
    public function mount()
    {
        $this->post = new Post();               //inicializo $post como instancia del modelo Post, para no error
        $this->identificador = rand();          //identificador aleatorio
    }

    //reglas de validacion de datos.
    //Deben existir ademas para poder sincronizar mediante wire:model="post.title" etc., sino no funciona
    protected $rules = [
        'post.title'   => 'required|max:100',
        'post.content' => 'required|max:100',
        'post.image'   => 'required|max:2048'       //2 MB
    ];

/*=====  End of Section comment block  ======*/


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


/*=============================================
=            Section comment block            =
=============================================*/
//para el caso de NO utilizar componentes de anidamiento y hacer la edicion de post en este componente
    public function edit( Post $post)
    {
        $this->post = $post;
        $this->open_edit = true;
    }


    public function update()
    {

        $this->validate();          //validacion de datos segun las reglas establecidas

        //si selecciono una imagen, borro el anterior archivo y actualizo la imagen
        if( $this->image)
        {
            if( $this->post->image)
                Storage::delete( $this->post->image);   //borro la vieja imagen

            $this->post->image = $this->image->store('posts');  //guardo imagen en posts/{image} y reasigno

            //si hay una imagen ya seleccionada, deberia borar la imagen o la carpeta temporaria de livewire que es public/storage/livewire-tmp/, aunque este link $this->image->temporaryUrl() apunta a http://livewire.test/livewire/preview-file/, en fin
            //Storage::delete( $this->image->temporaryUrl());   no funciono por el link
            //entonce borro la carpeta public/storage/livewire-tmp donde almaceno imagenes temporarias
            Storage::deleteDirectory('livewire-tmp');  // OJO!!! si hay multiusuarios esto esta mal. No borrar la carpeta.
        }

        $this->post->save();

        //reseteo. Se cierra el modal
        $this->reset(['open_edit', 'image']);

        //asigno un valor a identificador para que se refresque y actualice el <input file> de la vista
        $this->identificador = rand();          //identificador aleatorio

        // NO ES NECESARIO EMITIR UN EVENTO AL MISMO COMPONENTE EN EL CUAL ESTOY
        //emito un evento para que lo escuche el componente de livewire ShowPosts y actualice vista
//      $this->emit('render1');                     //lo envio a todos los componente que lo escuchan 
//      $this->emitTo('show-posts','render1');      //lo envio a un solo componente que lo escucha. en minuscula y con guiones
        
        //emito un evento que capturo en views/layouts/app.blade.php y muestre cartel de OK
        $this->emit('alert', 'El post se actualizó con éxito');

    }
/*=====  End of Section comment block  ======*/

}
