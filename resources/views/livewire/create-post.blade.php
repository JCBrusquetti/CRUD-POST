<div>
    <x-jet-danger-button data-bs-toggle="modal" data-bs-target="#modal-id-create">
        Crear nuevo post
    </x-jet-danger-button>

    <x-jet-dialog-modal id="create" class="m-0 p-0">
        <x-slot name="title">
            Crear nuevo post
        </x-slot>
        <x-slot name="content">
            <form>
                <div wire:loading wire:target="image" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Imagen cargandose...</strong> Espere un momento por favor.
                </div>
                @if ($image)
                    <div class="w-100">
                        <img class="img-fluid mx-auto d-block" src="{{$image->temporaryUrl()}}">
                    </div>
                @endif
            <div class="mb-2">
                <x-jet-label value="Titulo del post"/>
                <x-jet-input class="w-100 {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" wire:model.defer="title" />
                <x-jet-input-error for="title"/>
            </div>
            <div class="mb-2">
                <x-jet-label value="Contenido del post"/>
                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="6" wire:model.defer="content"></textarea>
                <x-jet-input-error for="content"/>
            </div>
            <div class="mb-2">
                <x-jet-input id="{{$id_image}}" class="w-100 {{$errors->has('image') ? 'is-invalid' : ''}}" type="file" wire:model.defer="image" />
                <x-jet-input-error for="image"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:loading.attr="disabled" wire:target="save, image" wire:click.prevent="save" type="button" class="btn btn-primary disabled:opacity-25">Agregar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </x-slot>
        </form>
    </x-jet-dialog-modal>
</div>
