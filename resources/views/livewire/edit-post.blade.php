<!--=====================================
=            Section comment            =
======================================-->
{{-- Este codigo(vista del componente EditPost.php) SOLO se usa en el caso de UTILIZAR componentes de anidamiento en los botones 'edit', sino tanto este codigo como su controlador EditPost.php quedan obsoletos--}}

{{-- Las view de Livewire SIEMPRE deben estar encerradas en un solo div padre, no puede haber mas de uno --}}
<div>
	{{-- ejecuta un metodo para cambiar el valor de la vble 'open' --}}
	<a class="btn1 btn1-green" wire:click="$set('open', true)">		{{-- clases agregadas por mi --}}
		<i class="fas fa-edit"></i>				{{-- icono de editar desde vendor/fontawesome-free/ --}}
	</a>

    {{-- modal que se muestra si 'open'==true. Esta cableado a la variable --}}
    <x-jet-dialog-modal wire:model="open">

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

                <div class="mb-4">
        			<x-jet-label>
        				Titulo del post
        			</x-jet-label>
        			{{--texto cableado a 'post.title'. defer para no renderizar con cada caracter escrito--}}
        			<x-jet-input type="text" class="w-full" wire:model.defer="post.title"></x-jet-input>

                    {{-- @error('title')
                        <span>
                            {{ $message }}
                        </span>
                    @enderror --}}
                    <x-jet-input-error for="post.title"></x-jet-input-error> {{--mediante componente jetstream--}}
                </div>

                <div class="mb-4">
        			<x-jet-label>
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
                </div>

                {{-- seleccion de archivo de imagen --}}
                <div>
                    {{-- el '$identificador' es para que livewire lo refresque y resetee --}}
                    <input type="file" wire:model="image" id="{{ $identificador }}" accept="image/*">

                    <x-jet-input-error for="image"></x-jet-input-error>
                </div>

    		</div>
    	</x-slot>

    	<x-slot name="footer">
    		{{-- boton de comp. jetstream que ejecuta un metodo para cambiar el valor de la vble 'open' --}}
    		<x-jet-secondary-button wire:click="$set('open', false)">
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

</div>
