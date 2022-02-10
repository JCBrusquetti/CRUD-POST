<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{

    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    public Post $post;
    public $image;
    public $id_image;
    public $open_edit = false;
    public string $sort = 'id';
    public string $direction = 'desc';
    protected $listeners = [
        'render'=>'render',
        'delete'=>'delete'
    ];
    protected array $rules = [
        'post.title'=>'required',
        'post.content'=>'required',
    ];
    public $cant = '10';
    protected $queryString = [
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'desc'],
        'search'=>['except'=>'']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->id_image = rand();
        $this->post = new Post();
    }

    public function render()
    {
        $posts = Post::where('title','like','%'.$this->search.'%')
            ->orWhere('content','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)->paginate($this->cant);
        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            }else{
                $this->direction = 'desc';
            }
        }else {
            $this->sort = $sort;
            $this->direction = 'desc';
        }
    }

    public function edit(Post $post)
    {
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();
        $this->reset(['open_edit','image']);
        $this->id_image = rand();
        $this->emit('edit',[
            'id'=>$this->post->id,
            'title_post'=>'Editado',
            'mensaje'=>'El post se edito satisfactoriamente'
        ]);
    }

    public function delete(Post $post)
    {
        $post->delete();
    }
}
