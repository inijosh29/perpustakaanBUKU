<?php

namespace App\Livewire\Book;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    // Form
    public $showForm = false;
    public $title;
    public $author;
    public $category = null;
    public $stock;
    public $tahun;

    // Dropdown kategori
    public $categories = ['Novel','Dongeng','Komik','Sejarah'];

    // Filter
    public $search;
    public $filterAbjad;
    public $filterTahun;
    public $categoryFilter;

    // Dropdown dynamic
    public $letters = [];
    public $years = [];

    public function mount()
    {
        $this->refreshYearsAndLetters();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function createBook()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->categories),
            'stock' => 'required|integer|min:0',
            'tahun' => 'required|digits:4|integer|min:1900|max:2099',
        ]);

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'stock' => $this->stock,
            'tahun' => $this->tahun,
        ]);

        $this->reset(['title','author','category','stock','tahun']);
        $this->refreshYearsAndLetters();

        session()->flash('success', 'Buku berhasil ditambahkan');
    }

    public function refreshYearsAndLetters()
    {
        $this->years = Book::orderBy('tahun','desc')->pluck('tahun')->unique()->toArray();
        $this->letters = Book::orderBy('title')->pluck('title')->map(function($t){
            return strtoupper(substr($t,0,1));
        })->unique()->toArray();
    }

    public function applyFilter()
    {
        // nothing to do, render() akan otomatis filter
    }

    public function resetFilter()
    {
        $this->search = null;
        $this->filterAbjad = null;
        $this->filterTahun = null;
        $this->categoryFilter = null;
    }

    public function render()
    {
        $query = Book::query();

        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%")
                  ->orWhere('author','like',"%{$this->search}%");
        }

        if ($this->filterAbjad) {
            $query->where('title', 'like', "{$this->filterAbjad}%");
        }

        if ($this->filterTahun) {
            $query->where('tahun', $this->filterTahun);
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $books = $query->latest()->get();

        return view('livewire.book.index', [
            'books' => $books
        ]);
    }
}
