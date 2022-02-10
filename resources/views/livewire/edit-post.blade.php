<div>
<x-jet-dialog-modal id="edit-{{$post->id}}">
    <x-slot name="title">
        Editar el post:
    </x-slot>
    <x-slot name="content">
        <div wire:loading wire:target="image" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Imagen cargandose...</strong> Espere un momento por favor.
        </div>
        @if ($image)
            <div class="w-100">
                <img class="img-fluid mx-auto d-block" src="{{$image->temporaryUrl()}}" alt="">
            </div>
        @else
            <div class="w-100">
                <img class="img-fluid mx-auto d-block" src="{{Storage::url($post->image)}}" alt="">
            </div>
        @endif
        <div class="mb-2">
            <x-jet-label value="Titulo del post"/>
            <x-jet-input wire:model="post.title" class="w-100" type="text" />
            <x-jet-input-error for="title"/>
        </div>
        <div class="mb-2">
            <x-jet-label value="Contenido del post"/>
            <textarea wire:model.defer="post.content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="6"></textarea>
            <x-jet-input-error for="content"/>
        </div>
        <div class="mb-2">
            <x-jet-input id="{{$id_image}}" class="w-100 {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" wire:model="image" />
            <x-jet-input-error for="image"/>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button wire:loading.attr="disabled" class="btn btn-success disabled:opacity-25" type="button" wire:click="save">
            Actualizar
        </button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Cancelar
        </button>
    </x-slot>
</x-jet-dialog-modal>
</div>
