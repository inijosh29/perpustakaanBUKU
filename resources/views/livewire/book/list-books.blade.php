<div style="max-width:1200px;margin:auto;padding:20px;color:black;">

    {{-- Notifikasi --}}
    @if (session()->has('success'))
        <div style="position:fixed;top:15px;left:15px;background:#16a34a;color:white;padding:10px 20px;border-radius:8px;z-index:9999;box-shadow:0 5px 15px rgba(0,0,0,.3);">
            {{ session('success') }}
        </div>
    @endif

    <h1 style="font-size:26px;font-weight:800;margin-bottom:15px;">Daftar Buku</h1>

    {{-- Toggle Form --}}
    <button wire:click="toggleForm"
        style="background:#16a34a;color:white;padding:10px 18px;border:none;border-radius:10px;cursor:pointer;margin-bottom:15px;font-weight:600;">
        {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
    </button>

    {{-- Form Tambah Buku --}}
    @if ($showForm)
        <div style="margin-top:20px;background:white;padding:20px;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.1);">
            <input wire:model.defer="title" placeholder="Judul" style="width:100%;padding:10px;margin-bottom:8px;border-radius:8px;border:1px solid #ddd;">
            @error('title') <span style="color:red">{{ $message }}</span> @enderror

            <input wire:model.defer="author" placeholder="Penulis" style="width:100%;padding:10px;margin-bottom:8px;border-radius:8px;border:1px solid #ddd;">
            @error('author') <span style="color:red">{{ $message }}</span> @enderror

            <select wire:model.defer="category" style="width:100%;padding:10px;margin-bottom:8px;border-radius:8px;border:1px solid #ddd;">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            @error('category') <span style="color:red">{{ $message }}</span> @enderror

            <input type="number" wire:model.defer="stock" placeholder="Stock" style="width:100%;padding:10px;margin-bottom:8px;border-radius:8px;border:1px solid #ddd;">
            <input type="number" wire:model.defer="tahun" placeholder="Tahun" style="width:100%;padding:10px;margin-bottom:10px;border-radius:8px;border:1px solid #ddd;">

            <button wire:click="createBook" style="background:#2563eb;color:white;padding:10px 18px;border:none;border-radius:10px;cursor:pointer;font-weight:600;">
                Simpan Buku
            </button>
        </div>
    @endif

    {{-- Filter --}}
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:20px;align-items:center;">
        <input type="text" wire:model.defer="search" placeholder="Search..." style="padding:10px;border-radius:8px;border:1px solid #ddd;flex:1;min-width:200px;">

        <select wire:model.defer="filterAbjad" style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Abjad</option>
            @foreach ($letters as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
            @endforeach
        </select>

        <select wire:model.defer="filterTahun" style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Tahun</option>
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select wire:model.defer="categoryFilter" style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        <button wire:click="applyFilter" style="background:#2563eb;color:white;padding:10px 18px;border:none;border-radius:10px;cursor:pointer;font-weight:600;">
            Apply Filter
        </button>

        <button wire:click="resetFilter" style="background:#6b7280;color:white;padding:10px 18px;border:none;border-radius:10px;cursor:pointer;font-weight:600;">
            Reset
        </button>
    </div>

    {{-- List / Grid Buku --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;margin-top:25px;">
        @foreach ($books as $book)
            <div wire:key="book-{{ $book->id }}" style="background:white;padding:18px;border-radius:18px;box-shadow:0 10px 20px rgba(0,0,0,.08); display:flex; flex-direction:column; justify-content:space-between; height:100%; transition:.2s;">
                <div>
                    <div style="font-size:18px;font-weight:800;margin-bottom:6px;">{{ $book->title }}</div>
                    <div style="color:#6b7280;">✍ {{ $book->author }}</div>
                    <div style="margin:10px 0;">
                        <span style="background:#e0f2fe;color:#0369a1;padding:6px 14px;border-radius:999px;font-size:12px;font-weight:700;">
                            {{ $book->category }}
                        </span>
                    </div>
                    <div style="margin-bottom:6px;color:#374151;font-weight:600;">Tahun: {{ $book->tahun ?? '-' }}</div>
                    @if ($book->stock > 0)
                        <div style="color:#16a34a;font-weight:700;">Stock: {{ $book->stock }}</div>
                    @else
                        <div style="color:#dc2626;font-weight:800;">❌ Out of stock</div>
                    @endif
                </div>

                <div>
                    @if ($book->stock > 0)
                        <button wire:click="rent({{ $book->id }})" style="width:100%;background:#2563eb;color:white;padding:12px;border:none;border-radius:12px;margin-top:12px;font-weight:700;cursor:pointer;transition:.2s;">
                            Rent
                        </button>
                    @else
                        <button disabled style="width:100%;background:#9ca3af;color:white;padding:12px;border:none;border-radius:12px;margin-top:12px;">Tidak Tersedia</button>
                    @endif
                    <button wire:click="deleteBook({{ $book->id }})" style="width:100%;background:#dc2626;color:white;padding:10px;border:none;border-radius:12px;margin-top:8px;font-weight:700;cursor:pointer;transition:.2s;">
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>
