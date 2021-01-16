<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $price;
    public $description;
    public $image;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function store()
    {

        $this->validate([
            'title' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required|max:180',
            'image' => 'image|max:1024'
        ]);

        $imageName = '';

        if ($this->image) {
            $imageName = \Str::slug($this->title, '-')
                . '-'
                . uniqid()
                . '.' . $this->image->getClientOriginalExtension();
        
            $this->image->storeAs('public', $imageName, 'local');
        }



        Product::create ([
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $imageName
        ]);

        $this->emit('productStored');
    }
}
