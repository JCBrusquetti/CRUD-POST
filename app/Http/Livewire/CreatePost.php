<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public bool $open = false;
    public string $title = '';
    public string $content = '';
    public $image;
    public $id_image;

    protected array $rules = [
        'title'=>'required',
        'content'=>'required',
        'image'=>'required|image|max:2048'
    ];

    public function mount()
    {
        $this->id_image = rand();
    }

    public function save()
    {
        $this->validate();
        $image = $this->image->store('posts');

        Post::create([
            'title'=>$this->title,
            'content'=>$this->content,
            'image'=>$image
        ]);

        $this->reset(['title','content','open', 'image']);
        $this->id_image = rand();

        $this->emit('render');
        $this->emit('save',[
            'title_post'=>'Guardado',
            'mensaje'=>'El post se guardo satisfactoriamente'
        ]);
    }

    public function render()
    {
        return view('livewire.create-post');
    }

}
