<?php

namespace App\Livewire\Book;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['rentalUpdated' => '$refresh'];

    /* ================= STATE ================= */
    public $search;
    public $filterAbjad;
    public $filterTahun;
    public $categoryFilter;
    public $filterRating; // <-- filter rating baru

    public $letters = [];
    public $years = [];
    public $categories = ['Novel', 'Dongeng', 'Komik', 'Sejarah'];

    /* ================= ADMIN FORM ================= */
    public $showForm = false;
    public $title;
    public $author;
    public $category;
    public $stock;
    public $tahun;
    public $sinopsis;
    public $image;

    /* ================= RENT FORM ================= */
    public $showRentForm = false;
    public $rentBookId;
    public $nama;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat;

    /* ================= COMMENTS ================= */
    public $showComments = [];
    public $commentText = [];
    public $commentRating = [];

    /* ================= DELETE ================= */
    public $confirmDeleteId;

    /* ================= PREVIEW ================= */
    public $previewImage;
    public $previewSinopsis;

    public function mount()
    {
        $this->letters = range('A', 'Z');

        $this->years = Book::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();
    }

    /* ================= ADMIN ================= */
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

   public function createBook()
{
    $this->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'category' => 'required|string',
        'stock' => 'required|integer|min:0',
        'tahun' => 'required|integer',
        'sinopsis' => 'nullable|string',
        'image' => 'nullable|image|max:10240', // 10MB
    ]);

    $path = 'books/default.png'; // default jika tidak ada gambar

    if ($this->image) {
        try {
            $path = $this->image->store('books', 'public');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal upload gambar: ' . $e->getMessage());
        }
    }

    Book::create([
        'title' => $this->title,
        'author' => $this->author,
        'category' => $this->category,
        'stock' => $this->stock,
        'tahun' => $this->tahun,
        'sinopsis' => $this->sinopsis,
        'image' => $path,
    ]);

    session()->flash('success', 'Buku berhasil ditambahkan');
    
    $this->reset(['title','author','category','stock','tahun','sinopsis','image','showForm']);
    $this->dispatch('$refresh'); // Livewire 3 syntax
}

    /* ================= RENT ================= */
    public function openRentForm($bookId)
    {
        if (!Auth::check()) return;

        $book = Book::findOrFail($bookId);

        if ($book->stock <= 0) {
            session()->flash('error', 'Stok buku sudah habis');
            return;
        }

        $this->rentBookId = $bookId;
        $this->showRentForm = true;
    }

    public function closeRentForm()
    {
        $this->reset([
            'showRentForm',
            'rentBookId',
            'nama',
            'tempat_lahir',
            'alamat',
        ]);
    }

    public function submitRent()
    {
        $this->validate([
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:13',
            'alamat' => 'required|string|max:255',
        ]);

        $book = Book::findOrFail($this->rentBookId);

        Rental::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'alamat' => $this->alamat,
            'rented_at' => now(),
            'status' => 'pending',
        ]);

        session()->flash(
            'success',
            'Permintaan rental berhasil dikirim dan menunggu persetujuan admin'
        );

        $this->closeRentForm();
    }

    /* ================= COMMENTS ================= */
    public function toggleComments($bookId)
    {
        $this->showComments[$bookId] = !($this->showComments[$bookId] ?? false);
    }

    public function submitComment($bookId)
    {
        $book = Book::findOrFail($bookId);

        $this->validate([
            "commentText.$bookId" => 'required|string|max:255',
            "commentRating.$bookId" => 'nullable|integer|min:1|max:5',
        ]);

        $book->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $this->commentText[$bookId],
            'rating' => $this->commentRating[$bookId] ?? null,
        ]);

        unset($this->commentText[$bookId], $this->commentRating[$bookId]);
    }

    public function deleteComment($commentId)
    {
        \App\Models\Comment::find($commentId)?->delete();
    }

    /* ================= DELETE BOOK ================= */
    public function confirmDelete($bookId)
    {
        $this->confirmDeleteId = $bookId;
    }

    public function cancelDelete()
    {
        $this->confirmDeleteId = null;
    }

    public function deleteBook()
    {
        Book::find($this->confirmDeleteId)?->delete();
        $this->confirmDeleteId = null;
        session()->flash('success', 'Buku berhasil dihapus');
    }

    /* ================= PREVIEW ================= */
    public function showImage($image, $sinopsis)
    {
        $this->previewImage = $image;
        $this->previewSinopsis = $sinopsis;
    }

    public function closeImage()
    {
        $this->previewImage = null;
        $this->previewSinopsis = null;
    }

    /* ================= ADMIN APPROVE RENTAL ================= */
    public function approveRental($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);
        $book = $rental->book;

        if ($book->stock <= 0) {
            session()->flash('error', 'Buku tidak cukup stock untuk disetujui');
            return; 
        }

        $book->decrement('stock');

        // ===================  ===================
       $rental->update([
    'status' => 'approved',
    'rented_at' => now(), // Biasanya menggunakan rented_at untuk mencatat kapan buku mulai dibawa
]);
        // ================================================================

        session()->flash('success', 'Rental disetujui dan stock buku dikurangi');
       $this->dispatch('rentalUpdated');
    }

    /* ================= RENDER ================= */
    public function render()
    {
        $query = Book::query();

        // Search
        if ($this->search) {
            $query->where(fn($q) =>
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('author', 'like', "%{$this->search}%")
            );
        }

        // Filters
        if ($this->filterAbjad) $query->where('title', 'like', "{$this->filterAbjad}%");
        if ($this->filterTahun) $query->where('tahun', $this->filterTahun);
        if ($this->categoryFilter) $query->where('category', $this->categoryFilter);

        // Filter rating
        if ($this->filterRating) {
            $query->whereHas('comments', function($q) {
                $q->select('book_id')
                  ->groupBy('book_id')
                  ->havingRaw('AVG(rating) >= ?', [$this->filterRating]);
            });
        }

        $books = $query->latest()->paginate(8);

        // Tambahkan rating rata-rata untuk setiap buku
        foreach ($books as $book) {
            $book->avgRating = round($book->comments()->avg('rating'), 1);
        }

        return view('livewire.book.index', [
            'books' => $books,
        ]);
    }
}
