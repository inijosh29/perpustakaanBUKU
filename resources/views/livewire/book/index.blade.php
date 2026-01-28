<div style="max-width:1200px;margin:auto;padding:20px;color:black;">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- NOTIFIKASI --}}
    @if (session()->has('success'))
        <div id="flash-message"
            style="background:#16a34a;color:white;padding:14px 20px;border-radius:12px;margin-bottom:20px;box-shadow:0 10px 20px rgba(0,0,0,.15);cursor:pointer;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-message');
                if (el) {
                    el.style.transition = 'opacity .4s ease';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 400);
                }
            }, 3000);
        </script>
    @endif

    <h1
        style="font-size:64px;font-weight:900;margin-bottom:30px;text-align:center;background:linear-gradient(90deg,#000,#22c55e);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-family:'Times New Roman', Times, serif">
        Daftar Buku
    </h1>

    {{-- TOGGLE TAMBAH --}}
    @if (auth()->user()?->isAdmin())
        <button wire:click="toggleForm"
            style="background:#16a34a;color:white;padding:12px 22px;border-radius:12px;margin-bottom:20px;font-weight:600;cursor:pointer;transition:.25s;"
            onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
            {{ $showForm ? 'Tutup Form' : '+ Tambah Buku' }}
        </button>
    @endif

    {{-- FORM TAMBAH --}}
    @if (auth()->user()?->isAdmin() && $showForm)
        <div
            style="margin-bottom:30px;background:white;padding:22px;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 10px 30px rgba(0,0,0,.15);">
            <form wire:submit.prevent="createBook">
                <input wire:model.defer="title" placeholder="Judul Buku"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;">
                <input wire:model.defer="author" placeholder="Penulis"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;">
                <select wire:model.defer="category"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;cursor:pointer;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
                <input wire:model.defer="stock" type="number" placeholder="Stock"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;">
                <input wire:model.defer="tahun" type="number" placeholder="Tahun Terbit"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;">
                <textarea wire:model.defer="sinopsis" maxlength="200" placeholder="Sinopsis singkat"
                    style="width:100%;padding:12px;margin-bottom:12px;border-radius:10px;border:1px solid #d1d5db;resize:none;height:80px;"></textarea>
                <input wire:model="image" type="file"
                    style="width:100%;padding:10px;margin-bottom:12px;border-radius:10px;border:1px dashed #9ca3af;cursor:pointer;">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"
                        style="width:120px;height:160px;object-fit:cover;border-radius:10px;margin-bottom:10px;">
                @endif
                <button type="submit"
                    style="background:#2563eb;color:white;padding:12px 22px;border-radius:10px;cursor:pointer;transition:.25s;"
                    onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'">
                    Simpan Buku
                </button>
            </form>
        </div>
    @endif

    {{-- FILTER --}}
    <div
        style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;padding:14px;border:1px solid #e5e7eb;border-radius:16px;background:#fafafa;box-shadow:0 6px 18px rgba(0,0,0,.08);">
        <input wire:model.live="search" placeholder="Search..."
            style="flex:1;padding:12px;border-radius:10px;border:1px solid #d1d5db;">
        <select wire:model.live="filterAbjad"
            style="padding:12px;border-radius:10px;border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Abjad</option>
            @foreach ($letters as $l)
                <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterTahun"
            style="padding:12px;border-radius:10px;border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
        <select wire:model.live="categoryFilter"
            style="padding:12px;border-radius:10px;border:1px solid #d1d5db;cursor:pointer;">
            <option value="">Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>
    </div>

    {{-- LIST BUKU --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:22px;">
        @foreach ($books as $book)
            <div
                style="background:white;padding:18px;border-radius:18px;border:1px solid #e5e7eb;box-shadow:0 8px 20px rgba(0,0,0,.15);transition:.25s;cursor:default;"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 36px rgba(0,0,0,.25)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,.15)';">

                {{-- GAMBAR --}}
                <div style="position:relative;">
                    <img src="{{ asset('storage/' . $book->image) }}"
                        style="width:100%;height:220px;object-fit:cover;border-radius:14px;">
                    <button wire:click="showImage('{{ $book->image }}','{{ addslashes($book->sinopsis) }}')"
                        style="position:absolute;bottom:8px;right:8px;font-size:20px;color:#000;background:transparent;border:none;cursor:pointer;transition:transform .2s, color .2s;"
                        onmouseover="this.style.transform='scale(1.2)'; this.style.color='#2563eb';"
                        onmouseout="this.style.transform='scale(1)'; this.style.color='#000';">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <b>{{ $book->title }}</b><br>
                {{ $book->author }}<br>
                {{ $book->category }} | {{ $book->tahun }}

                <div style="margin:10px 0;font-weight:bold;color:{{ $book->stock > 0 ? '#16a34a' : '#dc2626' }}">
                    Stock: {{ $book->stock }}
                </div>

                {{-- RENT --}}
                <button wire:click="openRentForm({{ $book->id }})"
                    style="width:100%;padding:10px;border-radius:8px;font-weight:600;cursor:pointer;background:#16a34a;color:white;margin-bottom:6px;transition: background .25s;"
                    onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                    Rent
                </button>

                {{-- HAPUS ADMIN --}}
                @if (auth()->user()?->isAdmin())
                    <button wire:click="confirmDelete({{ $book->id }})"
                        style="width:100%;padding:8px;border-radius:8px;background:#dc2626;color:white;cursor:pointer;margin-bottom:4px;transition: background .25s;"
                        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                        Hapus Buku
                    </button>
                @endif

                {{-- TOGGLE KOMENTAR --}}
                <button wire:click="toggleComments({{ $book->id }})"
                    style="font-size:20px;color:#000;background:transparent;border:none;cursor:pointer;transition:transform .2s, color .2s;"
                    onmouseover="this.style.transform='scale(1.2)'; this.style.color='#2563eb';"
                    onmouseout="this.style.transform='scale(1)'; this.style.color='#000';">
                    <i class="bi bi-chat-left-text"></i>
                </button>

                {{-- KOMENTAR --}}
                @if ($showComments[$book->id] ?? false)
                    <div style="margin-top:10px;padding-top:10px;border-top:1px solid #e5e7eb;font-size:13px;">
                        @php $avg = round($book->comments()->avg('rating'), 1); @endphp
                        <div style="margin-bottom:6px;">
                            <b>Rating:</b> {{ $avg ?: 'Belum ada' }} ⭐
                        </div>

                        @foreach ($book->comments as $c)
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                <div>
                                    <b>{{ $c->user->name }}</b>
                                    @if ($c->rating)
                                        <span style="color:#facc15">{{ str_repeat('⭐', $c->rating) }}</span>
                                    @endif
                                    <div>{{ $c->comment }}</div>
                                </div>
                                @if (auth()->id() === $c->user_id)
                                    <button wire:click="deleteComment({{ $c->id }})"
                                        style="background:transparent;border:none;color:#dc2626;cursor:pointer;font-size:16px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        @endforeach

                        @auth
                            @if (!$book->comments->where('user_id', auth()->id())->count())
                                <textarea wire:model.defer="commentText.{{ $book->id }}"
                                    style="width:100%;padding:8px;border-radius:8px;border:1px solid #d1d5db;margin-top:6px;"
                                    placeholder="Tulis komentar..."></textarea>
                                <select wire:model.defer="commentRating.{{ $book->id }}"
                                    style="width:100%;margin-top:6px;padding:6px;border-radius:8px;">
                                    <option value="">Rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                                    @endfor
                                </select>
                                <button wire:click="submitComment({{ $book->id }})"
                                    style="margin-top:6px;width:100%;padding:8px;border-radius:8px;background:#2563eb;color:white;cursor:pointer;">
                                    Kirim
                                </button>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- MODAL RENT --}}
    @if ($showRentForm)
        <div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:flex;align-items:center;justify-content:center;z-index:999;">
            <div style="background:white;padding:20px;border-radius:16px;max-width:400px;width:90%;position:relative;">
                <button wire:click="closeRentForm"
                    style="position:absolute;top:10px;right:10px;font-size:18px;font-weight:bold;background:#ef4444;color:white;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;">×</button>
                <h2 style="text-align:center;margin-bottom:14px;">Form Permintaan Rental</h2>
                <form wire:submit.prevent="submitRent">
                    <input wire:model.defer="nama" placeholder="Nama Lengkap"
                        style="width:100%;padding:12px;margin-bottom:10px;border-radius:10px;border:1px solid #d1d5db;">
                    <input wire:model.defer="tempat_lahir" placeholder="Tempat Lahir"
                        style="width:100%;padding:12px;margin-bottom:10px;border-radius:10px;border:1px solid #d1d5db;">
                    <input type="date" wire:model.defer="tanggal_lahir"
                        style="width:100%;padding:12px;margin-bottom:10px;border-radius:10px;border:1px solid #d1d5db;">
                    <textarea wire:model.defer="alamat" placeholder="Alamat"
                        style="width:100%;padding:12px;margin-bottom:10px;border-radius:10px;border:1px solid #d1d5db;height:80px;"></textarea>
                    <button type="submit"
                        style="width:100%;padding:12px;border-radius:10px;background:#2563eb;color:white;font-weight:600;cursor:pointer;">
                        Kirim Permintaan Rental
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL PREVIEW GAMBAR --}}
    @if ($previewImage)
        <div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div style="position:relative;background:white;padding:20px;border-radius:16px;max-width:500px;width:90%;">
                <button wire:click="closeImage"
                    style="position:absolute;top:10px;right:10px;font-size:18px;font-weight:bold;background:#ef4444;color:white;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;">×</button>
                <img src="{{ asset('storage/' . $previewImage) }}" style="width:100%;border-radius:12px;margin-bottom:12px;">
                <div>{{ $previewSinopsis }}</div>
            </div>
        </div>
    @endif
</div>
