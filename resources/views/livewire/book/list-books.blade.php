<div style="max-width:1200px;margin:auto;padding:20px;color:black;">

    {{-- ================= NOTIFIKASI ================= --}}
    @if (session()->has('success'))
        <div style="
            background:#16a34a;color:white;padding:10px 20px;
            border-radius:8px;z-index:9999;
            box-shadow:0 5px 15px rgba(0,0,0,.3);">
            {{ session('success') }}
        </div>


    @endif

    {{-- ================= JUDUL ================= --}}
    <h1 style="font-size:26px;font-weight:800;margin-bottom:15px;">
        Daftar Buku
    </h1>

    {{-- ================= TOGGLE FORM ================= --}}
    <button wire:click="toggleForm"
        class="btn-anim"
        style="background:#16a34a;color:white;padding:10px 18px;
        border:none;border-radius:10px;cursor:pointer;
        margin-bottom:15px;font-weight:600;">
        {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
    </button>

    {{-- ================= FORM TAMBAH BUKU ================= --}}
    @if ($showForm)
<div style="margin-top:20px;background:white;
    padding:20px;border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);">

    {{-- JUDUL --}}
    <input wire:model.defer="title" placeholder="Judul"
        style="width:100%;padding:10px;margin-bottom:4px;
        border-radius:8px;
        border:1px solid {{ $errors->has('title') ? '#dc2626' : '#ddd' }};">
    @error('title')
        <div style="color:#dc2626;font-size:13px;margin-bottom:8px;">
            {{ $message }}
        </div>
    @enderror

    {{-- PENULIS --}}
    <input wire:model.defer="author" placeholder="Penulis"
        style="width:100%;padding:10px;margin-bottom:4px;
        border-radius:8px;
        border:1px solid {{ $errors->has('author') ? '#dc2626' : '#ddd' }};">
    @error('author')
        <div style="color:#dc2626;font-size:13px;margin-bottom:8px;">
            {{ $message }}
        </div>
    @enderror

    {{-- KATEGORI --}}
    <select wire:model.defer="category"
        style="width:100%;padding:10px;margin-bottom:4px;
        border-radius:8px;
        border:1px solid {{ $errors->has('category') ? '#dc2626' : '#ddd' }};">
        <option value="">Pilih Kategori</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
    </select>
    @error('category')
        <div style="color:#dc2626;font-size:13px;margin-bottom:8px;">
            {{ $message }}
        </div>
    @enderror

    {{-- STOCK --}}
    <input type="number" wire:model.defer="stock" placeholder="Stock"
        style="width:100%;padding:10px;margin-bottom:4px;
        border-radius:8px;
        border:1px solid {{ $errors->has('stock') ? '#dc2626' : '#ddd' }};">
    @error('stock')
        <div style="color:#dc2626;font-size:13px;margin-bottom:8px;">
            {{ $message }}
        </div>
    @enderror

    {{-- TAHUN --}}
    <input type="number" wire:model.defer="tahun" placeholder="Tahun"
        style="width:100%;padding:10px;margin-bottom:4px;
        border-radius:8px;
        border:1px solid {{ $errors->has('tahun') ? '#dc2626' : '#ddd' }};">
    @error('tahun')
        <div style="color:#dc2626;font-size:13px;margin-bottom:10px;">
            {{ $message }}
        </div>
    @enderror

    {{-- BUTTON --}}
    <button wire:click="createBook"
        class="btn-anim"
        style="background:#2563eb;color:white;
        padding:10px 18px;border:none;
        border-radius:10px;font-weight:600;">
        Simpan Buku
    </button>
</div>
@endif


    {{-- ================= FILTER ================= --}}
    <div style="display:flex;flex-wrap:wrap;gap:10px;
        margin-top:20px;align-items:center;
        background:#f9fafb;padding:12px;border-radius:12px;">

        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Search..."
            style="padding:10px;border-radius:8px;
            border:1px solid #ddd;background:white;
            flex:1;min-width:200px;">

        <select wire:model.live="filterAbjad"
            style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Abjad</option>
            @foreach ($letters as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterTahun"
            style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Tahun</option>
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>

        <select wire:model.live="categoryFilter"
            style="padding:10px;border-radius:8px;border:1px solid #ddd;">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        {{-- <button wire:click="resetFilter"
            class="btn-anim"
            style="background:#6b7280;color:white;
            padding:10px 18px;border:none;
            border-radius:10px;font-weight:600;">
            Reset
        </button> --}}
    </div>

    {{-- ================= STYLE BUTTON ================= --}}
    <style>
        .btn-anim {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-anim:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
            box-shadow: 0 6px 14px rgba(0,0,0,.18);
        }
        .btn-anim:active {
            transform: scale(0.95);
            filter: brightness(0.92);
            box-shadow: 0 3px 8px rgba(0,0,0,.25);
        }
    </style>

    {{-- ================= LIST BUKU ================= --}}
    <div style="display:grid;
        grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
        gap:20px;margin-top:25px;">

        @forelse ($books as $book)
            <div wire:key="book-{{ $book->id }}"
                style="background:white;padding:18px;
                border-radius:18px;
                box-shadow:0 10px 20px rgba(0,0,0,.08);
                display:flex;flex-direction:column;
                justify-content:space-between;">

                <div>
                    <div style="font-size:18px;font-weight:800;">
                        {{ $book->title }}
                    </div>
                    <div style="color:#6b7280;">✍ {{ $book->author }}</div>

                    <div style="margin:10px 0;">
                        <span style="background:#e0f2fe;color:#0369a1;
                            padding:6px 14px;border-radius:999px;
                            font-size:12px;font-weight:700;">
                            {{ $book->category }}
                        </span>
                    </div>

                    <div style="font-weight:600;">
                        Tahun: {{ $book->tahun ?? '-' }}
                    </div>

                    @if ($book->stock > 0)
                        <div style="color:#16a34a;font-weight:700;">
                            Stock: {{ $book->stock }}
                        </div>
                    @else
                        <div style="color:#dc2626;font-weight:800;">
                            ❌ Out of stock
                        </div>
                    @endif
                </div>

                <div>
                    @if ($book->stock > 0)
                        <button wire:click="rent({{ $book->id }})"
                            class="btn-anim"
                            style="width:100%;background:#2563eb;
                            color:white;padding:12px;border:none;
                            border-radius:12px;margin-top:12px;
                            font-weight:700;">
                            Rent
                        </button>
                    @endif

                    <button wire:click="confirmDelete({{ $book->id }})"
                        class="btn-anim"
                        style="width:100%;background:#dc2626;
                        color:white;padding:10px;border:none;
                        border-radius:12px;margin-top:8px;
                        font-weight:700;">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;
                padding:40px;background:#f9fafb;
                border-radius:16px;border:1px dashed #d1d5db;">
                <b>Buku tidak ditemukan</b>
            </div>
        @endforelse
    </div>

    {{-- ================= MODAL KONFIRMASI ================= --}}
    @if($confirmingDelete)
    <div style="position:fixed;inset:0;
        background:rgba(0,0,0,.45);
        display:flex;align-items:center;
        justify-content:center;z-index:9999;">

        <div style="background:white;border-radius:18px;
            padding:24px;max-width:420px;width:100%;
            box-shadow:0 30px 60px rgba(0,0,0,.25);">

            <h3 style="font-size:20px;font-weight:800;">
                ⚠️ Konfirmasi Hapus
            </h3>

            <p style="margin:15px 0;color:#374151;">
                Yakin ingin menghapus buku ini?
                <br><b>Data tidak bisa dikembalikan.</b>
            </p>

            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button wire:click="cancelDelete"
                    class="btn-anim"
                    style="padding:10px 18px;border:none;
                    border-radius:12px;background:#e5e7eb;
                    font-weight:700;">
                    Batal
                </button>

                <button wire:click="deleteBook"
                    class="btn-anim"
                    style="padding:10px 18px;border:none;
                    border-radius:12px;background:#dc2626;
                    color:white;font-weight:800;">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
