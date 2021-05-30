<div>
	{{-- boton de comp. jetstream que ejecuta un metodo para cambiar el valor de la vble 'open' --}}
    <x-jet-danger-button wire:click="$set('open', true)">
    	Crear post
    </x-jet-danger-button>

    {{-- modal que se muestra si 'open'==true. Esta cableado a la variable --}}
    <x-jet-dialog-modal wire:model="open">

    	<x-slot name="title">
    		Crear nuevo post
    	</x-slot>

    	<x-slot name="content">
    		<div class="mb-4">
    			<x-jet-label>
    				Titulo del post
    			</x-jet-label>
    			{{--texto cableado a la vble 'title'. defer para no renderizar con cada caracter escrito--}}
    			<x-jet-input type="text" class="w-full mb-4" wire:model.defer="title">
    			</x-jet-input>

    			<x-jet-label>
    				Contenido del post
    			</x-jet-label>
    			{{--'form-control' lo defini en view/css/form.css--}}
    			{{-- texto cableado a la vble 'content'. defer para no renderizar con cada caracter escrito--}}
    			<textarea class="form-control w-full" rows="6" wire:model.defer="content">
    			</textarea> 
    		</div>
    	</x-slot>

    	<x-slot name="footer">
    		{{-- boton de comp. jetstream que ejecuta un metodo para cambiar el valor de la vble 'open' --}}
    		<x-jet-secondary-button wire:click="$set('open', false)">
    			Cancelar
    		</x-jet-secondary-button>

    		{{-- boton de comp. jetstream que ejecuta metodo 'save' para guardar post--}}
    		<x-jet-danger-button wire:click="save">
    			Guardar
    		</x-jet-danger-button>
    	</x-slot>
    </x-jet-dialog-modal>
</div>
