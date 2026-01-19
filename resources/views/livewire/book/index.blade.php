<div style="max-width:1200px;margin:auto;padding:20px;color:black;">

    {{-- ================= NOTIFIKASI ================= --}}
    @if (session()->has('success'))
        <div wire:poll.3000ms
            style="
                background:#16a34a;color:white;
                padding:14px 20px;border-radius:12px;
                margin-bottom:20px;
                box-shadow:0 10px 20px rgba(0,0,0,.15);
                opacity:1;
                transform:translateY(0);
                transition: opacity .5s ease, transform .5s ease;
            "
            x-data="{ show: true }"
            x-init="setTimeout(() => { show = false }, 3000)"
            x-show="show"
            x-transition.opacity.duration.500ms
            x-transition:leave.opacity.duration.500ms
            x-transition:leave.transform.duration.500ms
        >
            {{ session('success') }}
        </div>
    @endif

    <h1 style="font-size:26px;font-weight:800;margin-bottom:15px;">
        Daftar Buku
    </h1>

    {{-- ================= TOGGLE FORM ================= --}}
    <button wire:click="toggleForm"
        style="background:#16a34a;color:white;padding:10px 18px;
        border-radius:12px;margin-bottom:20px;font-weight:600;
        cursor:pointer;transition:.2s;"
        onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
        {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
    </button>

    {{-- ================= FORM TAMBAH BUKU ================= --}}
    @if ($showForm)
        <div style="margin-bottom:30px;background:white;padding:20px;
            border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.2);
            border:1px solid #ddd;">

            <form wire:submit.prevent="createBook">

                <input type="text" wire:model.defer="title" placeholder="Judul buku"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                @error('title') <span style="color:red">{{ $message }}</span> @enderror

                <input type="text" wire:model.defer="author" placeholder="Penulis"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                @error('author') <span style="color:red">{{ $message }}</span> @enderror

                <select wire:model.defer="category"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category') <span style="color:red">{{ $message }}</span> @enderror

                <input type="number" wire:model.defer="stock" placeholder="Stock"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                @error('stock') <span style="color:red">{{ $message }}</span> @enderror

                <input type="number" wire:model.defer="tahun" placeholder="Tahun terbit"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                @error('tahun') <span style="color:red">{{ $message }}</span> @enderror

                <input type="file" wire:model="image"
                    style="width:100%;padding:10px;margin-bottom:10px;cursor:pointer;border:1px solid #ccc;border-radius:8px;">
                @error('image') <span style="color:red">{{ $message }}</span> @enderror

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"
                        style="width:120px;height:160px;object-fit:cover;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">
                @endif

                <button type="submit"
                    style="background:#2563eb;color:white;padding:10px 18px;border-radius:8px;cursor:pointer;transition:.2s;"
                    onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'">
                    Simpan Buku
                </button>
            </form>
        </div>
    @endif

    {{-- ================= FILTER ================= --}}
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;padding:10px;border:1px solid #ddd;border-radius:12px;">

        <input wire:model.live="search" placeholder="Search..."
            style="padding:10px;border-radius:8px;border:1px solid #ccc;flex:1;">

        <select wire:model.live="filterAbjad" style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
            <option value="">Semua Abjad</option>
            @foreach ($letters as $l)
                <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterTahun" style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
            <option value="">Semua Tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>

        <select wire:model.live="categoryFilter" style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

    </div>

    {{-- ================= LIST BUKU ================= --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
        @forelse ($books as $book)
            <div
                style="background:white;padding:18px;border-radius:16px;
                    box-shadow:0 8px 20px rgba(0,0,0,.15);
                    transition:transform .25s ease, box-shadow .25s ease;cursor:pointer;"
                onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 14px 35px rgba(0,0,0,.25)';"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 20px rgba(0,0,0,.15)';"
            >
                <img src="{{ asset('storage/'.$book->image) }}"
                    style="width:100%;height:220px;object-fit:cover;border-radius:12px;margin-bottom:10px;">

                <b>{{ $book->title }}</b><br>
                {{ $book->author }}<br>
                {{ $book->category }} | {{ $book->tahun }}<br>

                <div style="margin:8px 0;font-weight:bold;color:{{ $book->stock > 0 ? '#16a34a' : '#dc2626' }}">
                    Stock: {{ $book->stock }}
                </div>

                @if ($book->stock > 0)
                    <button wire:click="rentBook({{ $book->id }})"
                        style="width:100%;background:#2563eb;color:white;padding:10px;border-radius:8px;margin-bottom:6px;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'">
                        Rent
                    </button>
                @endif

                <button wire:click="confirmDelete({{ $book->id }})"
                    style="width:100%;background:#dc2626;color:white;padding:8px;border-radius:8px;cursor:pointer;transition:.2s;"
                    onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                    Hapus
                </button>
            </div>
        @empty
            <p>Buku tidak ditemukan</p>
        @endforelse
    </div>

    {{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
    @if ($confirmDeleteId)
        <div style="position:fixed;inset:0;background:rgba(0,0,0,.45);
            display:flex;align-items:center;justify-content:center;z-index:9999;">
            <div style="background:white;padding:25px;border-radius:16px;width:320px;box-shadow:0 10px 30px rgba(0,0,0,.3);text-align:center;">
                <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">Hapus Buku?</h3>
                <p style="color:#555;margin-bottom:20px;">Buku akan dihapus permanen</p>
                <div style="display:flex;gap:10px;">
                    <button wire:click="deleteBook"
                        style="flex:1;background:#dc2626;color:white;padding:10px;border-radius:10px;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                        Ya, Hapus
                    </button>
                    <button wire:click="$set('confirmDeleteId', null)"
                        style="flex:1;background:#e5e7eb;padding:10px;border-radius:10px;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='#d1d5db'" onmouseout="this.style.background='#e5e7eb'">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
