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

    // Filter (LIVE)
    public $search = '';
    public $filterAbjad = '';
    public $filterTahun = '';
    public $categoryFilter = '';

    // Dropdown options
    public $letters = [];
    public $years = [];
    public $categories = ['Novel','Dongeng','Komik','Sejarah'];

    // Konfirmasi hapus
    public $confirmingDelete = false;
    public $deleteBookId = null;

    protected $rules = [
        'title'    => 'required|string|max:255',
        'author'   => 'required|string|max:255',
        'category' => 'required|in:Novel,Dongeng,Komik,Sejarah',
        'stock'    => 'required|integer|min:0',
        'tahun'    => 'required|integer|min:1900|max:2099',
    ];

    protected $messages = [
        'title.required'    => 'Judul buku wajib diisi',
        'author.required'   => 'Nama penulis wajib diisi',
        'category.required' => 'Kategori wajib dipilih',
        'stock.required'    => 'Stok wajib diisi',
        'tahun.required'    => 'Tahun terbit wajib diisi',
    ];

    public function mount()
    {
        $this->letters = range('A', 'Z');
        $this->refreshYears();
    }

    public function updated($property)
    {
        if (in_array($property, [
            'search',
            'filterAbjad',
            'filterTahun',
            'categoryFilter',
        ])) {
            $this->resetPage();
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function createBook()
    {
        // 🔥 VALIDASI WAJIB ISI SEMUA
        $this->validate();

        Book::create([
            'title'    => $this->title,
            'author'   => $this->author,
            'category' => $this->category,
            'stock'    => $this->stock,
            'tahun'    => $this->tahun,
        ]);

        $this->reset(['title','author','category','stock','tahun']);
        $this->showForm = false;
        $this->refreshYears();

        session()->flash('success', 'Buku berhasil ditambahkan');
    }

    public function refreshYears()
    {
        $this->years = Book::whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun','desc')
            ->pluck('tahun')
            ->toArray();
    }

    public function rent($id)
    {
        $book = Book::findOrFail($id);

        if ($book->stock < 1) {
            session()->flash('error', 'Buku habis');
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
        return redirect()->route('rentals');
    }

    public function confirmDelete($id)
    {
        $this->deleteBookId = $id;
        $this->confirmingDelete = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteBookId = null;
    }

    public function deleteBook()
    {
        Rental::where('book_id', $this->deleteBookId)->delete();
        Book::where('id', $this->deleteBookId)->delete();

        session()->flash('success', 'Buku berhasil dihapus');

        $this->confirmingDelete = false;
        $this->deleteBookId = null;

        $this->resetPage();
        $this->refreshYears();
    }

    public function render()
    {
        $query = Book::query();

        if ($this->filterAbjad) {
            $query->where('title', 'LIKE', $this->filterAbjad.'%');
        }

        if ($this->filterTahun) {
            $query->where('tahun', $this->filterTahun);
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title','LIKE','%'.$this->search.'%')
                    ->orWhere('author','LIKE','%'.$this->search.'%');
            });
        }

        return view('livewire.book.list-books', [
            'books' => $query->orderBy('id','desc')->paginate(10),
        ]);
    }
}
