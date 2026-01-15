<?php

namespace App\Livewire\Book;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class ListBooks extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Form
    public $showForm = false;
    public $title;
    public $author;
    public $category;
    public $stock;
    public $tahun;

    // Filter
    public $search = '';
    public $filterAbjad = '';
    public $filterTahun = '';
    public $categoryFilter = '';

    // Dropdown options
    public $letters = [];
    public $years = [];
    public $categories = ['Novel','Dongeng','Komik','Sejarah']; // hardcode supaya selalu muncul

    public function mount()
    {
        $this->letters = range('A', 'Z');
        $this->refreshYears();
    }

    // Toggle form tambah buku
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    // Create buku baru
    public function createBook()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', $this->categories),
            'stock' => 'required|integer|min:0',
            'tahun' => 'nullable|integer|min:1900|max:2099',
        ]);

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'stock' => $this->stock,
            'tahun' => $this->tahun,
        ]);

        $this->reset(['title', 'author', 'category', 'stock', 'tahun']);
        $this->showForm = false;
        $this->refreshYears(); // update dropdown tahun otomatis

        session()->flash('success', 'Buku berhasil ditambahkan');
    }

    // Refresh dropdown tahun
    public function refreshYears()
    {
        $this->years = Book::select('tahun')->whereNotNull('tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun')->toArray();
    }

    // Rent buku
    public function rent($id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock < 1) {
            session()->flash('error', 'Buku habis');
            return;
        }

        if (!Auth::check()) {
            session()->flash('error', 'Silakan login dulu');
            return;
        }

        Rental::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'category' => $book->category,
            'rented_at' => now(),
            'status' => 'rented',
        ]);

        $book->decrement('stock');

        session()->flash('success', 'Buku berhasil disewa');
        return redirect()->to('/rentals');
    }

    // Delete buku
    public function deleteBook($id)
    {
        Rental::where('book_id', $id)->delete();
        Book::where('id', $id)->delete();
        session()->flash('success', 'Buku berhasil dihapus');
        $this->resetPage();
        $this->refreshYears();
    }

    // Reset filter
    public function resetFilter()
    {
        $this->filterAbjad = '';
        $this->filterTahun = '';
        $this->categoryFilter = '';
        $this->search = '';
        $this->resetPage();
    }

    // Reset pagination saat filter/search berubah
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterAbjad() { $this->resetPage(); }
    public function updatingFilterTahun() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }

    public function render()
    {
        $query = Book::query();

        if ($this->filterAbjad) {
            $query->where('title', 'LIKE', $this->filterAbjad . '%');
        }

        if ($this->filterTahun) {
            $query->where('tahun', $this->filterTahun);
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->search) {
            $query->where(function($q){
                $q->where('title', 'LIKE', '%' . $this->search . '%')
                ->orWhere('author', 'LIKE', '%' . $this->search . '%');
            });
        }

        $books = $query->orderBy('id','desc')->paginate(10);

        return view('livewire.book.list-books', [
            'books' => $books,
            'letters' => $this->letters,
            'years' => $this->years,
            'categories' => $this->categories,
        ]);
    }
}
