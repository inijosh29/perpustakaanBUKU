<div style="max-width:1200px;margin:auto;padding:20px;color:black;">

    {{-- ================= NOTIFIKASI ================= --}}
    @if (session()->has('success'))
        <div
            style="background:#16a34a;color:white;padding:14px 20px;
            border-radius:12px;margin-bottom:20px;
            box-shadow:0 10px 20px rgba(0,0,0,.15);
            cursor:pointer;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= JUDUL ================= --}}
    <h1
        style="
        font-size:64px;font-weight:900;margin-bottom:30px;text-align:center;
        background:linear-gradient(90deg,#000,#22c55e);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        font-family:'Times New Roman', Times, serif">
        Daftar Buku
    </h1>

    {{-- ================= TOGGLE TAMBAH (ADMIN) ================= --}}
    @if (auth()->user()?->isAdmin())
        <button wire:click="toggleForm"
            style="background:#16a34a;color:white;
            padding:12px 22px;border-radius:12px;
            margin-bottom:20px;font-weight:600;
            cursor:pointer;transition:.25s;"
            onmouseover="this.style.background='#15803d'"
            onmouseout="this.style.background='#16a34a'">
            {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
        </button>
    @endif

    {{-- ================= FORM TAMBAH ================= --}}
    @if (auth()->user()?->isAdmin() && $showForm)
        <div
            style="margin-bottom:30px;background:white;padding:22px;
            border-radius:16px;border:1px solid #e5e7eb;
            box-shadow:0 10px 30px rgba(0,0,0,.15);">

            <form wire:submit.prevent="createBook">

                <input wire:model.defer="title" placeholder="Judul Buku"
                    style="width:100%;padding:12px;margin-bottom:12px;
                    border-radius:10px;border:1px solid #d1d5db;">

                <input wire:model.defer="author" placeholder="Penulis"
                    style="width:100%;padding:12px;margin-bottom:12px;
                    border-radius:10px;border:1px solid #d1d5db;">

                <select wire:model.defer="category"
                    style="width:100%;padding:12px;margin-bottom:12px;
                    border-radius:10px;border:1px solid #d1d5db;cursor:pointer;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>

                <input wire:model.defer="stock" type="number" placeholder="Stock"
                    style="width:100%;padding:12px;margin-bottom:12px;
                    border-radius:10px;border:1px solid #d1d5db;">

                <input wire:model.defer="tahun" type="number" placeholder="Tahun Terbit"
                    style="width:100%;padding:12px;margin-bottom:12px;
                    border-radius:10px;border:1px solid #d1d5db;">

                <input wire:model="image" type="file"
                    style="width:100%;padding:10px;margin-bottom:12px;
                    border-radius:10px;border:1px dashed #9ca3af;
                    cursor:pointer;">

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"
                        style="width:120px;height:160px;
                        object-fit:cover;border-radius:10px;">
                @endif

                <button type="submit"
                    style="background:#2563eb;color:white;
                    padding:12px 22px;border-radius:10px;
                    cursor:pointer;transition:.25s;"
                    onmouseover="this.style.background='#1e40af'"
                    onmouseout="this.style.background='#2563eb'">
                    Simpan Buku
                </button>
            </form>
        </div>
    @endif

    {{-- ================= FILTER ================= --}}
    <div
        style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;
        padding:14px;border:1px solid #e5e7eb;
        border-radius:16px;background:#fafafa;
        box-shadow:0 6px 18px rgba(0,0,0,.08);">

        <input wire:model.live="search" placeholder="Search..."
            style="flex:1;padding:12px;border-radius:10px;
            border:1px solid #d1d5db;">

        <select wire:model.live="filterAbjad"
            style="padding:12px;border-radius:10px;
            border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Abjad</option>
            @foreach ($letters as $l)
                <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterTahun"
            style="padding:12px;border-radius:10px;
            border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>

        <select wire:model.live="categoryFilter"
            style="padding:12px;border-radius:10px;
            border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>
    </div>

    {{-- ================= LIST BUKU ================= --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:22px;">
        @foreach ($books as $book)
            <div
                style="background:white;padding:18px;border-radius:18px;
                border:1px solid #e5e7eb;
                box-shadow:0 8px 20px rgba(0,0,0,.15);
                transition:.25s;cursor:default;"
                onmouseover="this.style.transform='translateY(-6px)';
                            this.style.boxShadow='0 16px 36px rgba(0,0,0,.25)'"
                onmouseout="this.style.transform='translateY(0)';
                            this.style.boxShadow='0 8px 20px rgba(0,0,0,.15)'">

                {{-- IMAGE + EYE --}}
                <div style="position:relative;">
                    <img src="{{ asset('storage/'.$book->image) }}"
                        style="width:100%;height:220px;
                        object-fit:cover;border-radius:14px;">

                    <button wire:click="showImage('{{ $book->image }}')"
                        style="position:absolute;top:10px;right:10px;
                        width:38px;height:38px;border-radius:50%;
                        background:rgba(0,0,0,.65);color:white;
                        border:none;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='rgba(0,0,0,.9)'"
                        onmouseout="this.style.background='rgba(0,0,0,.65)'">
                        👁
                    </button>
                </div>

                <b>{{ $book->title }}</b><br>
                {{ $book->author }}<br>
                {{ $book->category }} | {{ $book->tahun }}

                <div style="margin:10px 0;font-weight:bold;
                    color:{{ $book->stock > 0 ? '#16a34a' : '#dc2626' }}">
                    Stock: {{ $book->stock }}
                </div>

                {{-- RENT --}}
                <button wire:click="rentBook({{ $book->id }})"
                    @if ($book->stock <= 0) disabled @endif
                    style="
                    width:100%;padding:10px;border-radius:8px;
                    font-weight:600;transition:.2s;
                    background:{{ $book->stock > 0 ? '#16a34a' : '#9ca3af' }};
                    color:white;
                    cursor:{{ $book->stock > 0 ? 'pointer' : 'not-allowed' }};"
                    @if ($book->stock > 0)
                        onmouseover="this.style.background='#15803d'"
                        onmouseout="this.style.background='#16a34a'"
                    @endif>
                    {{ $book->stock > 0 ? 'Rent' : 'Stok Habis' }}
                </button>

                {{-- HAPUS (ADMIN) --}}
                @if (auth()->user()?->isAdmin())
                    <button wire:click="confirmDelete({{ $book->id }})"
                        style="width:100%;margin-top:8px;
                        background:#dc2626;color:white;
                        padding:10px;border-radius:10px;
                        cursor:pointer;transition:.25s;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#dc2626'">
                        Hapus
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    {{-- ================= MODAL IMAGE ================= --}}
    @if ($previewImage)
        <div style="position:fixed;inset:0;background:rgba(0,0,0,.7);
            display:flex;align-items:center;justify-content:center;
            z-index:9999;cursor:pointer;"
            wire:click="closeImage">

            <div style="background:white;padding:20px;border-radius:18px;
                box-shadow:0 20px 40px rgba(0,0,0,.4);
                cursor:default;"
                wire:click.stop>

                <img src="{{ asset('storage/'.$previewImage) }}"
                    style="max-width:90vw;max-height:80vh;
                    border-radius:14px;object-fit:contain;">

                <button wire:click="closeImage"
                    style="display:block;margin:14px auto 0;
                    background:#dc2626;color:white;
                    padding:10px 20px;border-radius:10px;
                    cursor:pointer;transition:.25s;"
                    onmouseover="this.style.background='#b91c1c'"
                    onmouseout="this.style.background='#dc2626'">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    {{-- ================= MODAL DELETE ================= --}}
    @if (auth()->user()?->isAdmin() && $confirmDeleteId)
        <div style="position:fixed;inset:0;background:rgba(0,0,0,.6);
            display:flex;align-items:center;justify-content:center;
            z-index:9999;">

            <div style="background:white;padding:24px;
                border-radius:18px;width:320px;
                box-shadow:0 20px 40px rgba(0,0,0,.35);
                text-align:center;">

                <h3 style="font-size:20px;font-weight:700;margin-bottom:16px;">
                    Hapus Buku?
                </h3>

                <div style="display:flex;gap:12px;">
                    <button wire:click="deleteBook"
                        style="flex:1;background:#dc2626;color:white;
                        padding:10px;border-radius:10px;
                        cursor:pointer;transition:.25s;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#dc2626'">
                        Ya, Hapus
                    </button>

                    <button wire:click="$set('confirmDeleteId', null)"
                        style="flex:1;background:#e5e7eb;
                        padding:10px;border-radius:10px;
                        cursor:pointer;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
