<div>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="table-responsive form-control">
        <div class="m-2 d-flex align-items-center">
            <div class="me-2 d-flex align-items-center">
                <x-jet-label value="Mostrar" />
                <select wire:model="cant" class="form-select mx-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <x-jet-label value="entradas" />
            </div>

            <x-jet-input class="mx-3 flex-1" placeholder="Escriba aquí" type="text" wire:model="search" />
            @livewire('create-post')
        </div>
        @if ($posts->count())
            <x-table>
                <x-slot name="thead">
                    <tr>
                        <th wire:click="order('id')" style="cursor: pointer"  scope="col">
                            <div class="d-flex justify-content-between">
                                ID
                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt mt-1 ms-3"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt mt-1 ms-3"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1 ms-3"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="order('title')" style="cursor: pointer" scope="col">
                            <div class="d-flex justify-content-between m-0 p-0">
                                Title
                                @if ($sort == 'title')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt mt-1 ms-3"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt mt-1 ms-3"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1 ms-3"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="order('content')" style="cursor: pointer" scope="col">
                            <div class="d-flex justify-content-between m-0 p-0">
                                Content
                                @if ($sort == 'content')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt mt-1 ms-3"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt mt-1 ms-3"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1 ms-3"></i>
                                @endif
                            </div>
                        </th>
                        <th scope="col"></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($posts as $item)
                    <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->title}}</td>
                        <td>{{$item->content}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                {{-- <livewire:edit-post :post="$post" :wire:key="$post->id" /> --}}
                                <button wire:click="edit({{$item}})" type="button" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="$emit('deletePost', {{$item->id}})" type="button" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @else
            <div class="text-muted my-3">
                No se encontraron registros
            </div>
        @endif
        @if ($posts->hasPages())
            <div>
                {!! $posts->links() !!}
            </div>
        @endif
    </div>

    <x-jet-dialog-modal wire:model="open_edit">
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
                <x-jet-input wire:model.defer="post.title" class="w-100" type="text" />
                <x-jet-input-error for="title"/>
            </div>
            <div class="mb-2">
                <x-jet-label value="Contenido del post"/>
                <textarea wire:model.defer="post.content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="6"></textarea>
                <x-jet-input-error for="content"/>
            </div>
            <div class="mb-2">
                <x-jet-input id="{{$id_image}}" class="w-100 {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" wire:model.defer="image" />
                <x-jet-input-error for="image"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:loading.attr="disabled" class="btn btn-success disabled:opacity-25" type="button" wire:click="update">
                Actualizar
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Cancelar
            </button>
        </x-slot>
    </x-jet-dialog-modal>
    @push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('save', function(datos) {
            $('#modal-id-create').modal('hide')
            Swal.fire(
                datos['title_post'],
                datos['mensaje'],
                'success'
            )
        });
        Livewire.on('edit', function(datos) {
            id = datos['id'];
            $('#modal-id-edit-'+id).modal('hide')
            Swal.fire(
                datos['title_post'],
                datos['mensaje'],
                'success'
            )
        });
        Livewire.on('deletePost', postId => {
            Swal.fire({
                title: '¿Estas seguro de eliminar el registro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borralo'
                }).then((result) => {
                if (result.isConfirmed) {

                    Livewire.emitTo('show-posts', 'delete', postId);

                    Swal.fire(
                    '¡Eliminado!',
                    'Su registro ha sido eliminado.',
                    'success'
                    )
                }
                })
        })
    </script>
    @endpush


</div>
