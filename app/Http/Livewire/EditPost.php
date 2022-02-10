<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;


    public $open = false;
    public Post $post;
    public $image;
    public $id_image;
    protected array $rules = [
        'post.title'=>'required',
        'post.content'=>'required',
    ];

    public function mount(Post $post)
    {
        $this->post=$post;
        $this->id_image = rand();
    }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();
        $this->reset(['image']);
        $this->id_image = rand();
        $this->emit('render');
        $this->emit('edit',[
            'id'=>$this->post->id,
            'title_post'=>'Editado',
            'mensaje'=>'El post se edito satisfactoriamente'
        ]);
    }


    public function render()
    {
        return view('livewire.edit-post');
    }
}
