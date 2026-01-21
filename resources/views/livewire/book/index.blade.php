<div style="max-width:1200px;margin:auto;padding:20px;color:black;">

    {{-- ================= NOTIFIKASI ================= --}}
    @if (session()->has('success'))
        <div wire:poll.3000ms
            style="background:#16a34a;color:white;padding:14px 20px;border-radius:12px;margin-bottom:20px;
            box-shadow:0 10px 20px rgba(0,0,0,.15);cursor:pointer;"
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition.opacity.duration.500ms>
            {{ session('success') }}
        </div>
    @endif

   <h1 style="
    font-size:64px;
    font-weight:900;
    margin-bottom:26px;
    text-align:center;
    letter-spacing:1px;
    background:linear-gradient(90deg,#000000,#22c55e);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    text-shadow:0 6px 18px rgba(22,163,74,.25);
    position:relative;
    font-family:'Times New Roman', Times, serif
">
    Daftar Buku

    <span style="
        position:absolute;
        left:50%;
        bottom:-12px;
        transform:translateX(-50%);
        width:90px;
        height:4px;
        background:linear-gradient(90deg,#16a34a,#22c55e);
        border-radius:999px;
        box-shadow:0 6px 16px rgba(22,163,74,.4);
        display:block;
    "></span>
</h1>



    {{-- ================= TOGGLE FORM ================= --}}
    <button wire:click="toggleForm"
        style="background:#16a34a;color:white;padding:10px 18px;border-radius:12px;
        margin-bottom:20px;font-weight:600;cursor:pointer;"
        onmouseover="this.style.background='#15803d'"
        onmouseout="this.style.background='#16a34a'">
        {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
    </button>

    {{-- ================= FORM TAMBAH BUKU ================= --}}
    @if ($showForm)
        <div style="margin-bottom:30px;background:white;padding:20px;border-radius:12px;
            box-shadow:0 6px 18px rgba(0,0,0,.2);border:1px solid #ddd;">

            <form wire:submit.prevent="createBook">

                <input type="text" wire:model.defer="title" placeholder="Judul buku"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

                <input type="text" wire:model.defer="author" placeholder="Penulis"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

                <select wire:model.defer="category"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;cursor:pointer;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>

                <input type="number" wire:model.defer="stock" placeholder="Stock"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

                <input type="number" wire:model.defer="tahun" placeholder="Tahun terbit"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

                <input type="file" wire:model="image"
                    style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;cursor:pointer;">

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"
                        style="width:120px;height:160px;object-fit:cover;border-radius:8px;">
                @endif

                <button type="submit"
                    style="background:#2563eb;color:white;padding:10px 18px;border-radius:8px;cursor:pointer;"
                    onmouseover="this.style.background='#1e40af'"
                    onmouseout="this.style.background='#2563eb'">
                    Simpan Buku
                </button>
            </form>
        </div>
    @endif

    {{-- ================= FILTER ================= --}}
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;
        padding:10px;border:1px solid #ddd;border-radius:12px;">
        <input wire:model.live="search" placeholder="Search..."
            style="padding:10px;border-radius:8px;border:1px solid #ccc;flex:1;">

        <select wire:model.live="filterAbjad"
            style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
            <option value="">Semua Abjad</option>
            @foreach ($letters as $l)
                <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterTahun"
            style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
            <option value="">Semua Tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>

        <select wire:model.live="categoryFilter"
            style="padding:10px;border-radius:8px;border:1px solid #ccc;cursor:pointer;">
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
                <div
    style="
    background:white;
    padding:18px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
    cursor:pointer;
    transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    "

                onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,.25)'"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 20px rgba(0,0,0,.15)'"
            >

                {{-- IMAGE + EYE --}}
                <div style="position:relative;">
                    <img src="{{ asset('storage/'.$book->image) }}"
                        style="width:100%;height:220px;object-fit:cover;border-radius:12px;margin-bottom:10px;">

                    <button wire:click="showImage('{{ $book->image }}')"
                        style="position:absolute;top:10px;right:10px;
                        background:rgba(0,0,0,.6);color:white;border:none;
                        width:36px;height:36px;border-radius:50%;
                        cursor:pointer;"
                        onmouseover="this.style.background='rgba(0,0,0,.85)'"
                        onmouseout="this.style.background='rgba(0,0,0,.6)'">
                        👁
                    </button>
                </div>

                <b>{{ $book->title }}</b><br>
                {{ $book->author }}<br>
                {{ $book->category }} | {{ $book->tahun }}

                <div style="margin:8px 0;font-weight:bold;color:{{ $book->stock > 0 ? '#16a34a' : '#dc2626' }}">
                    Stock: {{ $book->stock }}
                </div>

                {{-- RENT --}}
                <button
                    wire:click="rentBook({{ $book->id }})"
                    {{ $book->stock <= 0 ? 'disabled' : '' }}
                    style="width:100%;
                        background:{{ $book->stock > 0 ? '#16a34a' : '#9ca3af' }};
                        color:white;padding:10px;border-radius:8px;
                        cursor:{{ $book->stock > 0 ? 'pointer' : 'not-allowed' }};"
                    @if($book->stock > 0)
                        onmouseover="this.style.background='#15803d '"
                        onmouseout="this.style.background='#16a34a'"
                    @endif>
                    {{ $book->stock > 0 ? 'Rent' : 'Out of Stock' }}
                </button>

                {{-- HAPUS --}}
                <button wire:click="confirmDelete({{ $book->id }})"
                    style="width:100%;margin-top:6px;background:#dc2626;color:white;
                    padding:8px;border-radius:8px;cursor:pointer;"
                    onmouseover="this.style.background='#b91c1c'"
                    onmouseout="this.style.background='#dc2626'">
                    Hapus
                </button>
            </div>
        @empty
            <p>Buku tidak ditemukan</p>
        @endforelse
    </div>

    {{-- ================= MODAL PREVIEW IMAGE ================= --}}
    @if ($previewImage)
        <div style="position:fixed;inset:0;background:rgba(0,0,0,.7);
            display:flex;align-items:center;justify-content:center;z-index:9999;">
            <div style="position:relative;">
                <img src="{{ asset('storage/'.$previewImage) }}"
                    style="max-width:90vw;max-height:90vh;border-radius:12px;">
                <button wire:click="closeImage"
                    style="position:absolute;top:-12px;right:-12px;
                    background:#dc2626;color:white;border:none;
                    width:32px;height:32px;border-radius:50%;
                    cursor:pointer;"
                    onmouseover="this.style.background='#b91c1c'"
                    onmouseout="this.style.background='#dc2626'">
                    ✕
                </button>
            </div>
        </div>
    @endif

    {{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
    @if ($confirmDeleteId)
        <div style="position:fixed;inset:0;background:rgba(0,0,0,.45);
            display:flex;align-items:center;justify-content:center;z-index:9999;">
            <div style="background:white;padding:25px;border-radius:16px;width:320px;
                box-shadow:0 10px 30px rgba(0,0,0,.3);text-align:center;">
                <h3 style="font-size:18px;font-weight:700;margin-bottom:10px;">Hapus Buku?</h3>
                <p style="color:#555;margin-bottom:20px;">Buku akan dihapus permanen</p>
                <div style="display:flex;gap:10px;">
                    <button wire:click="deleteBook"
                        style="flex:1;background:#dc2626;color:white;
                        padding:10px;border-radius:10px;cursor:pointer;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#dc2626'">
                        Ya, Hapus
                    </button>
                    <button wire:click="$set('confirmDeleteId', null)"
                        style="flex:1;background:#e5e7eb;padding:10px;
                        border-radius:10px;cursor:pointer;"
                        onmouseover="this.style.background='#d1d5db'"
                        onmouseout="this.style.background='#e5e7eb'">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
