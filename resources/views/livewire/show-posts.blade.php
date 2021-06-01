{{-- como este componente de livewire lo utilizo de controlador de rutas en web.php, siempre se instancia la vista principal layouts/app.blade.php antes de esta propia vista, por lo tanto estoy dentro del componente <x-app-layout> --}}
{{-- Las view de Livewire SIEMPRE deben estar encerradas en un solo div padre, no puede haber mas de uno --}}

<div wire:init="loadPosts">				{{-- invoco el metodo para iniciar carga de los registros de la DB --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
            Listado de posts
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">    
    	{{-- instancio al componente para armar la tabla --}}
	    <x-table>

	    	<div class="px-6 py-4 flex items-center">
	    		{{-- selector de cantidad a mostrar --}}
	    		<div class="flex items-center">
	    			<span>Mostrar</span>

	    			<select wire:model="cantidad" class="mx-2 form-control">	{{-- form-control lo defini yo --}}
	    				<option value="5">5</option>
	    				<option value="10">10</option>
	    				<option value="15">15</option>
	    				<option value="20">20</option>
	    			</select>

	    			<span>registros</span>
	    		</div>

				{{-- input buscar lo vinculo(enlazo) con la propiedad 'search' --}}
	    		<x-jet-input type="text" wire:model="search" class="flex-1 mx-4" placeholder="Escriba lo que quiere buscar">
	    		</x-jet-input>	{{-- componente de jettream --}}

	    		{{-- boton de crear nuevo post --}}
	    		{{-- instancio al componente livewire app/Http/Livewire/CreatePost.php --}}
	    		@livewire('create-post')
	    	</div>

    		{{-- @if ($posts->count()) --}}  {{-- este no puede utilizarse en inicio retrasado readyToLoad porque no existe posts como arreglo de Post --}}
    		@if ( count( $posts))						{{-- este metodo de php si se puede utilizar --}}
		        <table class="min-w-full divide-y divide-gray-200">
		          <thead class="bg-gray-50">
		            <tr>
		            {{-- a cada titulo le agrego click y el metodo para ordenar las listas --}}
		              <th scope="col" wire:click="order('id')" class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
		                ID
		                {{-- ordenamiento. las clases 'fas fa-sort-' son desde vendor/fontawesome-free/--}}
		                @if ($sort == 'id')
		                	@if ($direction == 'asc')
				                <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				            @else
				                <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
		                	@endif
		                @else
			                <i class="fas fa-sort float-right mt-1"></i>
		                @endif
		              </th>
		              <th scope="col" wire:click="order('title')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
		                Title
		                {{-- ordenamiento. las clases 'fas fa-sort-' son desde vendor/fontawesome-free/ --}}
		                @if ($sort == 'title')
		                	@if ($direction == 'asc')
				                <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				            @else
				                <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
		                	@endif
		                @else
			                <i class="fas fa-sort float-right mt-1"></i>
		                @endif
		              </th>
		              <th scope="col" wire:click="order('content')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
		                Content
		                {{-- ordenamiento. las clases 'fas fa-sort-' son desde vendor/fontawesome-free/ --}}
		                @if ($sort == 'content')
		                	@if ($direction == 'asc')
				                <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				            @else
				                <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
		                	@endif
		                @else
			                <i class="fas fa-sort float-right mt-1"></i>
		                @endif
		              </th>
		              <th scope="col" class="relative px-6 py-3">
		                <span class="sr-only">Edit</span>
		              </th>
		            </tr>
		          </thead>

		          <tbody class="bg-white divide-y divide-gray-200">
					@foreach ($posts as $post1)
			            <tr>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post1->id }}</div>
			              </td>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post1->title }}</div>
			              </td>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post1->content }}</div>
			              </td>
			              {{-- boton y link editar --}}
			              <td class="px-6 py-4 text-sm font-medium float-right">

	    					{{-- Componente de anidamiento. Instancio reiteradas veces al componente livewire app/Http/Livewire/EditPost.php. La llave (key) debe existir y ser unica para que livewire pueda diferenciar un llamado de otro--}}
	    					{{-- @livewire('edit-post', ['post' => $post1], key($post1->id)) --}}

	    					{{-- el utilizar componentes de anidamiento no resulta optimizado, ya que se crea un componente+modal+... por cada elemento del listado de posts. Podemos hacer algo mas optimizado instanciando un metodo y pasandole la informacion del post correspondiente. Creamos un solo modal al final de este codigo --}}
	    					{{-- en este caso instancio directamente el metodo 'edit' y le paso el 'post1' --}}
							<a class="btn1 btn1-green" wire:click="edit( {{ $post1 }})">	{{-- clase agregada --}}
								<i class="fas fa-edit"></i>  {{-- icono de editar desde vendor/fontawesome-free/--}}
							</a>

			              </td>
			            </tr>
					@endforeach
		          </tbody>
		        </table>

			    {{-- si hay paginas muestro links --}}
			    @if ($posts->hasPages())
				    <div class="px-6 py-3">
				    	{{ $posts->links() }} 		{{-- muestro paginado --}}
				    </div>
			    @endif

			@else
		    	<div class="px-6 py-4">
		    		No existe ninigun registro coincidente.
		    	</div>

    		@endif

	    </x-table>

    </div>

<!--=====================================
=            Section comment            =
======================================-->
{{-- modal que se muestra si 'open'==true. Esta cableado a la variable.
Lo pongo aca para el caso de NO utilizar componentes de anidamiento, sino se saca de aqui --}}
    <x-jet-dialog-modal wire:model="open_edit">

    	<x-slot name="title">
    		Editar post '{{ $post->title }}'
    	</x-slot>

    	<x-slot name="content">
    		<div class="mb-4">

                {{-- cartel extraido de https://v1.tailwindcss.com/components/alerts y modificado --}}
                {{-- mensaje mientras se esta cargando de fondo la propiedad 'image' --}}
                <div wire:loading wire:target="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                  <strong class="font-bold">Cargando imagen...</strong>
                  <span class="block sm:inline">Por favor espere hasta que se cargue la imagen</span>
                </div>

				{{-- si hay una imagen ya seleccionada, la muestro arriba desde la carpeta temporaria de livewire que es public/storage/livewire-tmp/, aunque este link apunta a http://livewire.test/livewire/preview-file/, en fin--}}
                @if( $image)
                    <img src="{{ $image->temporaryUrl() }}" class="mb-4">
                @elseif ($post->image) 						{{-- sino muestro imagen del post --}}
                    <img src="{{ Storage::url($post->image) }}" class="mb-4">
                @endif

    			<x-jet-label>
    				Titulo del post
    			</x-jet-label>
    			{{--texto cableado a 'post.title'. defer para no renderizar con cada caracter escrito--}}
    			<x-jet-input type="text" class="w-full" wire:model.defer="post.title"></x-jet-input>

                @error('title')
                    <span>
                        {{ $message }}
                    </span>
                @enderror
                <x-jet-input-error for="post.title"></x-jet-input-error> {{--mediante componente jetstream--}}

    			<x-jet-label class="mt-4">
    				Contenido del post
    			</x-jet-label>
    			{{--'form-control' lo defini en view/css/form.css--}}
    			{{-- texto cableado a 'post.content'. defer para no renderizar con cada caracter escrito--}}
    			<textarea class="form-control w-full" rows="6" wire:model.defer="post.content">
    				{{ $post->content }}
    			</textarea> 

                {{-- @error('content')
                    <span>
                        {{ $message }}
                    </span>
                @enderror --}}
                <x-jet-input-error for="post.content"></x-jet-input-error> {{--mediante componente jetstream--}}

                {{-- seleccion de archivo de imagen --}}
                <div class="mt-4">
                    {{-- el '$identificador' es para que livewire lo refresque y resetee --}}
                    <input type="file" wire:model="image" id="{{ $identificador }}" accept="image/*">

                    <x-jet-input-error for="image"></x-jet-input-error>
                </div>

    		</div>
    	</x-slot>

    	<x-slot name="footer">
    		{{-- boton de comp. jetstream ejecuta un metodo para cambiar el valor de la vble 'open_edit' --}}
    		<x-jet-secondary-button wire:click="$set('open_edit', false)">
    			Cancelar
    		</x-jet-secondary-button>

    		{{-- boton de comp. jetstream que completa metodo 'update' para guardar post. --}}
            {{-- Se oculta mientras se completa el metodo 'update' --}}
    		{{-- <x-jet-danger-button wire:click="update" wire:loading.remove wire:target="update"> --}}
            {{-- cambia de color mientras se completa el metodo 'update' --}}
            {{-- <x-jet-danger-button wire:click="update" wire:loading.class="bg-blue-500" wire:target="update"> --}}
            {{-- deshabilitado y opaco mientras se completan el metodo 'update' y la prop. 'image' --}}
            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" class="disabled:opacity-25" wire:target="update, image">
    			Guardar
    		</x-jet-danger-button>

            {{-- mensaje mientras se esta completando una accion de fondo, por ej. update --}}
            {{-- <span wire:loading>Cargando...</span>  --}}          {{-- cualquier metodo o demora --}}
            <span wire:loading wire:target="update">Cargando...</span>    {{-- solo el metodo update --}}
            {{-- con distintos displays
            <span wire:loading.flex wire:target="update">Cargando...</span>
            <span wire:loading.grid wire:target="update">Cargando...</span>
            <span wire:loading.inline wire:target="update">Cargando...</span>
            <span wire:loading.table wire:target="update">Cargando...</span> --}}

    	</x-slot>
    </x-jet-dialog-modal>

<!--====  End of Section comment  ====-->

</div>
