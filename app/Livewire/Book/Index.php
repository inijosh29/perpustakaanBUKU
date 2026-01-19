<?php

namespace App\Livewire\Book;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    public $showForm = false;

    public $title;
    public $author;
    public $category;
    public $stock;
    public $tahun;
    public $image;

    public $confirmDeleteId = null;

    public $categories = ['Novel','Dongeng','Komik','Sejarah'];

    public $search;
    public $filterAbjad;
    public $filterTahun;
    public $categoryFilter;

    public $letters = [];
    public $years = [];

    /* ========================= */
    /* INIT */
    /* ========================= */
    public function mount()
    {
        $this->letters = range('A', 'Z');
        $this->refreshYearsAndLetters();
    }

    /* ========================= */
    /* AUTO RESET PAGINATION */
    /* ========================= */
    public function updated($property)
    {
        if (in_array($property, [
            'search',
            'filterAbjad',
            'filterTahun',
            'categoryFilter'
        ])) {
            $this->resetPage();
        }
    }

    /* ========================= */
    /* TOGGLE FORM */
    /* ========================= */
    public function toggleForm()
    {
        $this->showForm = ! $this->showForm;
    }

    /* ========================= */
    /* CREATE BOOK */
    /* ========================= */
    public function createBook()
    {
        $this->validate([
            'title'    => 'required|string|max:255',
            'author'   => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->categories),
            'stock'    => 'required|integer|min:0',
            'tahun'    => 'required|digits:4',
            'image'    => 'required|image|max:2048', // ✅ WAJIB
        ]);

        $path = $this->image->store('books', 'public'); // ✅ TIDAK NULL

        Book::create([
            'title'    => $this->title,
            'author'   => $this->author,
            'category' => $this->category,
            'stock'    => $this->stock,
            'tahun'    => $this->tahun,
            'image'    => $path,
        ]);

        $this->reset(['title','author','category','stock','tahun','image']);
        $this->showForm = false;

        $this->refreshYearsAndLetters();

        session()->flash('success', 'Buku berhasil ditambahkan');
    }

    /* ========================= */
    /* RENT BOOK */
    /* ========================= */
    public function rentBook($id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock <= 0) return;

        Rental::create([
            'user_id'   => Auth::id(),
            'book_id'   => $book->id,
            'rented_at' => now(),
            'status'    => 'rented',
        ]);

        $book->decrement('stock');

        return redirect()
            ->route('rentals')
            ->with('success', 'Buku berhasil disewa');
    }

    /* ========================= */
    /* DELETE BOOK */
    /* ========================= */
    public function confirmDelete($id)
    {
        $this->confirmDeleteId = $id;
    }

    public function deleteBook()
    {
        Book::findOrFail($this->confirmDeleteId)->delete();
        $this->confirmDeleteId = null;

        $this->refreshYearsAndLetters();

        session()->flash('success', 'Buku berhasil dihapus');
    }

    /* ========================= */
    /* REFRESH FILTER DATA */
    /* ========================= */
    public function refreshYearsAndLetters()
    {
        $this->years = Book::pluck('tahun')
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();
    }

    /* ========================= */
    /* RENDER + FILTER */
    /* ========================= */
    public function render()
    {
        $query = Book::query();

        // 🔍 SEARCH
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('author', 'like', "%{$this->search}%");
            });
        }

        // 🔤 ABJAD
        if ($this->filterAbjad) {
            $query->where('title', 'like', "{$this->filterAbjad}%");
        }

        // 📅 TAHUN
        if ($this->filterTahun) {
            $query->where('tahun', $this->filterTahun);
        }

        // 🗂️ KATEGORI
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        return view('livewire.book.index', [
            'books' => $query->latest()->paginate(8),
        ]);
    }
}
