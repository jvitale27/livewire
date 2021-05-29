{{-- como este componente de livewire lo utilizo de controlador de rutas en web.php, siempre se instancia la vista principal layouts/app.blade.php antes de esta propia vista, por lo tanto estoy dentro del componente <x-app-layout> --}}
{{-- Las view de Livewire SIEMPRE deben estar encerradas en un solo div padre, no puede haber mas de uno --}}
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">    
    	{{-- instancio al componente para armar la tabla --}}
	    <x-table>

			{{-- input buscar lo vinculo(enlazo) con la propiedad 'search' --}}
	    	<div class="px-6 py-4">
	    		<x-jet-input type="text" wire:model="search" class="w-full" placeholder="Escriba lo que quiere buscar">
	    		</x-jet-input>	{{-- componente de jettream --}}
	    	</div>

    		@if ($posts->count())
		        <table class="min-w-full divide-y divide-gray-200">
		          <thead class="bg-gray-50">
		            <tr>
		            {{-- a cada titulo le agrego click y el metodo para ordenar las listas --}}
		              <th scope="col" wire:click="order('id')" class="w-20 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
		                ID
		                {{-- ordenamiento --}}
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
		                {{-- ordenamiento --}}
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
		                {{-- ordenamiento --}}
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
					@foreach ($posts as $post)
			            <tr>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post->id }}</div>
			              </td>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post->title }}</div>
			              </td>
			              <td class="px-6 py-4">
			                <div class="text-sm text-gray-900">{{ $post->content }}</div>
			              </td>
			              <td class="px-6 py-4 text-right text-sm font-medium">
			                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
			              </td>
			            </tr>
					@endforeach
		          </tbody>
		        </table>
			@else
		    	<div class="px-6 py-4">
		    		No existe ninigun registro coincidente.
		    	</div>

    		@endif

	    </x-table>

	    {{ $posts->links() }}

    </div>
</div>
