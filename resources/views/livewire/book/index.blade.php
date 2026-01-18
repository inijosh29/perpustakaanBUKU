<div style="margin-top:20px;background:white;padding:15px;border-radius:8px;box-shadow:0 0 5px rgba(0,0,0,.2);color:black;">

    <h2 style="font-size:20px;font-weight:bold;margin-bottom:10px;">Tambah Buku</h2>

    <!-- Judul -->
    <input type="text" wire:model="title" placeholder="Judul buku"
           style="width:100%;padding:10px;margin-bottom:10px;border:2px solid #333;border-radius:6px;background:#fff;color:#000;">
    @error('title') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Penulis -->
    <input type="text" wire:model="author" placeholder="Penulis"
           style="width:100%;padding:10px;margin-bottom:10px;border:2px solid #333;border-radius:6px;background:#fff;color:#000;">
    @error('author') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Debug: cek isi $categories -->
    {{-- <pre>{{ print_r($categories, true) }}</pre> --}}

    <!-- Kategori -->
    <select wire:model="category"
            style="width:100%;padding:10px;margin-bottom:10px;border:2px solid #333;border-radius:6px;background:#fff;color:#000;">
        <option value="" disabled selected>-- Pilih Kategori --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
    </select>
    @error('category') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Stock -->
    <input type="number" wire:model="stock" placeholder="Stock"
           style="width:100%;padding:10px;margin-bottom:10px;border:2px solid #333;border-radius:6px;background:#fff;color:#000;">
    @error('stock') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Tahun -->
    <input type="number" wire:model="tahun" placeholder="Tahun terbit"
           style="width:100%;padding:10px;margin-bottom:10px;border:2px solid #333;border-radius:6px;background:#fff;color:#000;"
           min="1900" max="2099">
    @error('tahun') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Tombol Simpan -->
    <button wire:click="createBook"
            style="margin-top:10px;background:#2563eb;color:white;padding:10px 15px;border:none;border-radius:5px;cursor:pointer;">
        Simpan Buku
    </button>

</div>

<!-- Filter Tahun -->
<div style="margin-top:20px;">
    <label>Filter Tahun:</label>
    <select wire:model="filterYear"
            style="width:150px;padding:5px;margin-bottom:10px;border:1px solid #333;border-radius:5px;">
        <option value="">-- Semua Tahun --</option>
        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>
</div>

<!-- List Buku -->
<div style="margin-top:20px;">
    @foreach($books as $book)
        <div style="padding:10px;border-bottom:1px solid #ccc;">
            <strong>{{ $book->title }}</strong> - {{ $book->author }} | {{ $book->category }} | Tahun: {{ $book->tahun }} | Stock: {{ $book->stock }}
        </div>
    @endforeach
</div>
