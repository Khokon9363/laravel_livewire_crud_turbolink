<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book as BookModel;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Book extends Component
{
    use WithPagination; // akhane giye tailwind er place a bootstrap kore dite hobe
    use WithFileUploads;

    public $number;
    public $name;
    public $image;
    public $iteration; // this is for null src after store the image

    public $search;
    
    public $editMode = false;
    public $editId;

    public function check()
    {
        $this->validate([
            'number' => 'max:10|unique:books',
            'name'   => 'max:10|unique:books',
        ]);
    }
    public function store()
    {
        $this->validate([
            'number' => 'required|max:10|unique:books',
            'name'   => 'required|max:10|unique:books',
            'image'  => 'required|image'
        ]);
        $name = $this->image->getClientOriginalName();
        $rename = time().date('_d-m-y_').$name;

        $this->image->storeAs('photos', $rename, 'public');

        $book = new BookModel();
        $book->number = $this->number;
        $book->name = $this->name;
        $book->image = $rename;
        $book->save();
        session()->flash('success', 'Book successfully saved.');

        $this->number = '';
        $this->name = '';
        $this->image = ''; // this is for null preview src after store the image
        $this->iteration++; // this is for null src after store the image
    }

    public function destroy($id)
    {
        BookModel::destroy($id);
        session()->flash('success', 'Book successfully deleted.');
    }

    public function edit($id)
    {
        $book = BookModel::find($id);
        $this->number = $book->number;
        $this->name = $book->name;

        $this->editMode = true;
        $this->editId = $book->id;
    }

    public function update()
    {
        $book = BookModel::find($this->editId);
        $this->validate([
            'number' => 'required|max:10',
            'name'   => 'required|max:10'
        ]);
        $book->number = $this->number;
        $book->name = $this->name;
        $book->save();
        session()->flash('success', 'Book successfully updated.');

        $this->number = '';
        $this->name = '';
    }
    
    public function search()
    {
        
    }

    public function render()
    {
        $books = BookModel::
                            where('name', 'LIKE','%'.$this->search.'%')
                          ->orWhere('number', 'LIKE','%'.$this->search.'%')
                          ->orderBy('created_at', 'DESC')->paginate(10);
        return view('livewire.book', compact('books'));
    }
}
