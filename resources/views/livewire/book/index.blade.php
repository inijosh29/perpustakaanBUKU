<div style="max-width:1280px;margin:40px auto;padding:20px;color:#334155;font-family:'Segoe UI', Roboto, Helvetica, Arial, sans-serif;min-height:100vh;">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- NOTIFIKASI SUCCESS --}}
    @if (session()->has('success'))
        <div id="flash-message"
            style="background:#dcfce7;border-left:4px solid #16a34a;color:#14532d;padding:16px 24px;border-radius:8px;margin-bottom:24px;box-shadow:0 4px 12px rgba(22, 163, 74, 0.15);cursor:pointer;display:flex;align-items:center;gap:12px;font-weight:500;">
            <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-message');
                if (el) {
                    el.style.transition = 'all .5s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if (session()->has('error'))
        <div id="error-message"
            style="background:#fee2e2;border-left:4px solid #dc2626;color:#7f1d1d;padding:16px 24px;border-radius:8px;margin-bottom:24px;box-shadow:0 4px 12px rgba(220, 38, 38, 0.15);cursor:pointer;display:flex;align-items:center;gap:12px;font-weight:500;">
            <i class="bi bi-exclamation-circle-fill" style="font-size:1.2rem;"></i>
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('error-message');
                if (el) {
                    el.style.transition = 'all .5s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:20px;">
        <h1
            style="font-size:3rem;font-weight:800;margin:0;background:linear-gradient(135deg, #064e3b 0%, #10b981 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:-1px;">
            Daftar Buku
        </h1>

        {{-- TOGGLE TAMBAH --}}
        @if (auth()->user()?->isAdmin())
            <button wire:click="toggleForm"
                style="background:linear-gradient(135deg, #10b981 0%, #059669 100%);color:white;padding:12px 24px;border-radius:50px;font-weight:600;cursor:pointer;transition:all 0.3s ease;border:none;box-shadow:0 4px 15px rgba(16, 185, 129, 0.4);display:flex;align-items:center;gap:8px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.5)'" 
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.4)'">
                <i class="bi bi-plus-lg"></i>
                {{ $showForm ? 'Tutup Form' : 'Tambah Buku' }}
            </button>
        @endif
    </div>

    {{-- FORM TAMBAH --}}
    @if (auth()->user()?->isAdmin() && $showForm)
        <div
            style="margin-bottom:40px;background:#ffffff;padding:30px;border-radius:20px;border:1px solid #e2e8f0;box-shadow:0 20px 40px -5px rgba(0,0,0,0.05);animation: fadeIn 0.4s ease-out;">
            
            {{-- ERROR DISPLAY --}}
            @if ($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:16px 20px;border-radius:12px;margin-bottom:20px;display:flex;align-items:start;gap:10px;">
                    <i class="bi bi-exclamation-triangle-fill" style="margin-top:2px;"></i>
                    <div>
                        <strong style="display:block;margin-bottom:6px;font-size:0.95rem;">⚠️ Perhatikan kesalahan berikut:</strong>
                        <ul style="margin:0;padding-left:18px;font-size:0.9rem;color:#b91c1c;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom:4px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="createBook" enctype="multipart/form-data">
                @csrf
                
                <div style="display:grid;grid-template-columns: 1fr 1fr;gap:20px;">
                    {{-- JUDUL --}}
                    <div>
                        <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Judul Buku</label>
                        <input wire:model.defer="title" placeholder="Contoh: Laskar Pelangi" required
                            style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;transition:0.2s;font-size:0.95rem;"
                            onfocus="this.style.borderColor='#10b981'; this.style.background='#fff'; this.style.outline='none';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                        @error('title')
                            <div style="color:#ef4444;font-size:0.8rem;margin-top:6px;display:flex;align-items:center;gap:4px;">
                                <i class="bi bi-x-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- PENULIS --}}
                    <div>
                        <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Penulis</label>
                        <input wire:model.defer="author" placeholder="Nama Penulis" required
                            style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;transition:0.2s;font-size:0.95rem;"
                            onfocus="this.style.borderColor='#10b981'; this.style.background='#fff'; this.style.outline='none';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                        @error('author')
                            <div style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns: 1fr 1fr 1fr;gap:20px;margin-top:20px;">
                    {{-- KATEGORI --}}
                    <div>
                        <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Kategori</label>
                        <select wire:model.defer="category" required
                            style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;cursor:pointer;appearance:none;background-image:url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');background-repeat:no-repeat;background-position:right.7em top 50%;background-size:.65em auto;">
                            <option value="" style="color:#94a3b8;">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STOCK --}}
                    <div>
                        <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Stok</label>
                        <input wire:model.defer="stock" type="number" placeholder="0" min="0" required
                            style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;">
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Tahun Terbit</label>
                        <input wire:model.defer="tahun" type="number" placeholder="2024" min="1900" max="2100" required
                            style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;">
                    </div>
                </div>

                {{-- SINOPSIS --}}
                <div style="margin-top:20px;">
                    <label style="display:block;font-size:0.9rem;font-weight:600;color:#475569;margin-bottom:8px;">Sinopsis Singkat</label>
                    <textarea wire:model.defer="sinopsis"  placeholder="Ceritakan sedikit tentang buku ini..."
                        style="width:100%;padding:14px 16px;border-radius:10px;border:1px solid #cbd5e1;background:#f8fafc;resize:none;height:100px;line-height:1.5;"></textarea>
                </div>

                {{-- UPLOAD GAMBAR --}}
                <div style="margin-top:24px;padding:20px;border:2px dashed #cbd5e1;border-radius:12px;background:#f8fafc;text-align:center;transition:0.2s;"
                     onmouseover="this.style.borderColor='#10b981'; this.style.background='#f0fdf4';"
                     onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                    
                    <div style="margin-bottom:10px;">
                        <i class="bi bi-cloud-upload" style="font-size:2rem;color:#94a3b8;"></i>
                    </div>
                    
                    <label style="display:inline-block;padding:8px 16px;background:#e2e8f0;border-radius:8px;font-size:0.9rem;font-weight:600;cursor:pointer;transition:0.2s;"
                           onmouseover="this.style.background='#cbd5e1'"
                           onmouseout="this.style.background='#e2e8f0'">
                        Pilih File Gambar
                        <input wire:model="image" type="file" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" style="display:none;">
                    </label>
                    <p style="font-size:0.8rem;color:#64748b;margin-top:8px;">Maksimal 2MB (JPG, PNG, WEBP)</p>
                    
                    {{-- LOADING STATE --}}
                    <div wire:loading wire:target="image" 
                        style="margin-top:15px;color:#059669;font-size:0.9rem;font-weight:500;">
                        <i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Sedang mengupload...
                    </div>
                    
                    @error('image')
                        <div style="color:#ef4444;font-size:0.85rem;margin-top:10px;background:#fee2e2;padding:8px;border-radius:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    {{-- PREVIEW IMAGE --}}
                    @if ($image)
                        <div wire:loading.remove wire:target="image" style="margin-top:20px;position:relative;display:inline-block;">
                            <img src="{{ $image->temporaryUrl() }}"
                                style="width:140px;height:200px;object-fit:cover;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);"
                                alt="Preview">
                            
                            {{-- REMOVE BUTTON --}}
                            <button type="button" wire:click="$set('image', null)"
                                style="position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:14px;font-weight:bold;line-height:1;box-shadow:0 4px 6px -1px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-x"></i>
                            </button>

                            <div style="font-size:0.75rem;color:#64748b;margin-top:6px;">
                                {{ $image->getClientOriginalName() }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- SUBMIT BUTTON --}}
                <div style="margin-top:30px;">
                    <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="createBook"
                        style="width:100%;background:linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);color:white;padding:16px;border-radius:12px;cursor:pointer;transition:.25s;font-weight:600;font-size:1rem;border:none;box-shadow:0 4px 6px -1px rgba(37, 99, 235, 0.3);display:flex;justify-content:center;align-items:center;gap:8px;"
                        onmouseover="if(!this.disabled) { this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(37, 99, 235, 0.4)'; }" 
                        onmouseout="if(!this.disabled) { this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(37, 99, 235, 0.3)'; }">
                        
                        <span wire:loading.remove wire:target="createBook">
                            <i class="bi bi-save-fill"></i> Simpan Buku
                        </span>
                        <span wire:loading wire:target="createBook" style="display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- FILTER BAR --}}
    <div
        style="display:flex;gap:12px;margin-bottom:32px;padding:20px;background:#ffffff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);flex-wrap:wrap;align-items:center;">
        <div style="flex:1;min-width:200px;position:relative;">
            <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;"></i>
            <input wire:model.live="search" placeholder="Cari judul, penulis..."
                style="width:100%;padding:12px 12px 12px 40px;border-radius:10px;border:1px solid #e2e8f0;background:#f8fafc;font-size:0.95rem;transition:0.2s;"
                onfocus="this.style.borderColor='#10b981'; this.style.background='#fff'; this.style.outline='none';"
                onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
        </div>
        
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <select wire:model.live="filterAbjad"
                style="padding:10px 16px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;font-size:0.9rem;">
                <option value="">Semua Abjad</option>
                @foreach ($letters as $l)
                    <option value="{{ $l }}">{{ $l }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterTahun"
                style="padding:10px 16px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;font-size:0.9rem;">
                <option value="">Semua Tahun</option>
                @foreach ($years as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
            <select wire:model.live="categoryFilter"
                style="padding:10px 16px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;font-size:0.9rem;">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterRating"
                style="padding:10px 16px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;font-size:0.9rem;">
                <option value="">Semua Rating</option>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- GRID CONTAINER --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    @foreach ($books as $book)
        <div class="group relative bg-white dark:bg-gray-900 rounded-[2rem] border border-slate-100 dark:border-gray-800 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col">
            
            {{-- IMAGE SECTION --}}
            <div class="relative p-4">
                <div class="relative h-64 w-full overflow-hidden rounded-[1.5rem] shadow-inner bg-slate-100">
                    @php
                        $imagePath = $book->image
                            ? \Illuminate\Support\Facades\Storage::url($book->image)
                            : 'https://via.placeholder.com/400x600?text=No+Cover';
                    @endphp
                    <img src="{{ $imagePath }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    
                    {{-- OVERLAY BADGE --}}
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm">
                            {{ $book->category }}
                        </span>
                    </div>

                    {{-- QUICK VIEW BUTTON --}}
                    <button wire:click="showImage('{{ $book->image }}','{{ addslashes($book->sinopsis) }}')" 
                        class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-white p-3 rounded-full shadow-xl transform scale-75 group-hover:scale-100 transition-transform duration-300">
                            <flux:icon.eye class="w-6 h-6 text-slate-800" />
                        </div>
                    </button>
                </div>
            </div>

            

            {{-- CONTENT SECTION --}}
            <div class="px-6 pb-6 flex-grow flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs font-bold text-slate-400">{{ $book->tahun }}</span>
                    @php $avg = round($book->comments()->avg('rating'), 1); @endphp
                    <div class="flex items-center gap-1 text-amber-400 font-bold text-sm">
                        <flux:icon.star variant="mini" />
                        <span>{{ $avg ?: '0.0' }}</span>
                    </div>
                </div>

                <h3 class="text-lg font-black text-slate-800 dark:text-white leading-tight mb-1 line-clamp-2 min-h-[3.5rem]">
                    {{ $book->title }}
                </h3>
                
                <p class="text-sm font-medium text-slate-500 mb-4 flex items-center gap-1">
                    <flux:icon.user variant="micro" />
                    {{ $book->author }}
                </p>

                <div class="mt-auto space-y-3">
                    {{-- STOCK INDICATOR --}}
                    <div class="flex justify-between items-center text-[11px] font-bold uppercase tracking-wider">
                        <span class="text-slate-400">Availability</span>
                        <span class="{{ $book->stock > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $book->stock }} Units Left
                        </span>
                    </div>

                    {{-- RENT BUTTON --}}
                    <button wire:click="openRentForm({{ $book->id }})"
                        @if ($book->stock <= 0) disabled @endif
                        class="w-full py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 
                        {{ $book->stock > 0 
                            ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg shadow-emerald-200 dark:shadow-none' 
                            : 'bg-slate-200 text-slate-500 cursor-not-allowed' }}">
                        @if ($book->stock > 0)
                            <flux:icon.plus-circle variant="mini" /> Pinjam Buku
                        @else
                            <flux:icon.x-circle variant="mini" /> Out of Stock
                        @endif
                    </button>

                    {{-- ACTIONS --}}
                    <div class="flex gap-2">
                        @if (auth()->user()?->isAdmin())
                            <button wire:click="confirmDelete({{ $book->id }})" class="p-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors flex-1 flex justify-center border border-rose-100">
                                <flux:icon.trash variant="mini" />
                            </button>
                        @endif

                        <button wire:click="toggleComments({{ $book->id }})" 
                            class="p-2.5 rounded-xl transition-all flex-1 flex items-center justify-center gap-2 font-bold text-xs
                            {{ ($showComments[$book->id] ?? false) ? 'bg-slate-800 text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-100' }}">
                            <flux:icon.chat-bubble-bottom-center-text variant="mini" />
                            {{ $book->comments->count() }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- COMMENTS SECTION (FIXED LOGIC) --}}
           @if ($showComments[$book->id] ?? false)
    <div class="border-t border-slate-50 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-950 p-6 space-y-4 animate-in slide-in-from-top duration-300">
        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Reviews</h4>
        
        <div class="max-h-48 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
            @forelse ($book->comments as $c)
                <div class="bg-white dark:bg-gray-900 p-3 rounded-xl shadow-sm border border-slate-100 dark:border-gray-800">
                    
                    <div class="flex justify-between items-center mb-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-700 dark:text-gray-200">
                                {{ $c->user->name }}
                            </span>

                            <span class="text-[10px] text-amber-400">
                                {{ str_repeat('★', $c->rating) }}
                            </span>
                        </div>

                        {{-- ICON HAPUS (USER SENDIRI / ADMIN) --}}
                        @auth
                            @if (
                                auth()->id() === $c->user_id ||
                                auth()->user()->isAdmin()
                            )
                                <button
                                    wire:click="deleteComment({{ $c->id }})"
                                    class="text-slate-400 hover:text-rose-600 transition"
                                    title="Hapus komentar"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        @endauth
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        {{ $c->comment }}
                    </p>
                </div>
            @empty
                <p class="text-xs text-center text-slate-400 py-2">
                    Belum ada ulasan.
                </p>
            @endforelse
        </div>

        @auth
            @if (!$book->comments->where('user_id', auth()->id())->count())
                <div class="pt-2 space-y-2">
                    <textarea wire:model.defer="commentText.{{ $book->id }}" 
                        class="w-full p-3 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                        placeholder="Bagikan pendapat Anda..."></textarea>
                    <div class="flex gap-2">
                        <select wire:model.defer="commentRating.{{ $book->id }}" class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-xl px-2 text-xs font-bold outline-none">
                            <option value="">Rate</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                        <button wire:click="submitComment({{ $book->id }})"
                            class="flex-1 bg-slate-800 text-white py-2 rounded-xl text-xs font-bold hover:bg-black transition-all">
                            Post Review
                        </button>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endif

        </div>
    @endforeach
</div>
    {{-- MODAL KONFIRMASI DELETE --}}
    @if ($confirmDeleteId)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:2000;animation: fadeIn 0.2s;">
            <div style="background:white;padding:30px;border-radius:20px;max-width:400px;width:90%;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
                <div style="width:60px;height:60px;background:#fee2e2;color:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px auto;">
                    <i class="bi bi-exclamation-lg" style="font-size:2rem;"></i>
                </div>
                <h3 style="margin:0 0 10px 0;font-size:1.25rem;color:#1e293b;">Hapus Buku?</h3>
                <p style="color:#64748b;margin-bottom:24px;">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus buku ini?</p>
                <div style="display:flex;gap:12px;justify-content:center;">
                    <button wire:click="deleteBook"
                        style="padding:12px 24px;border-radius:10px;background:#ef4444;color:white;cursor:pointer;border:none;font-weight:600;transition:0.2s;"
                        onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                        Ya, Hapus
                    </button>
                    <button wire:click="cancelDelete"
                        style="padding:12px 24px;border-radius:10px;background:#f1f5f9;color:#475569;cursor:pointer;border:none;font-weight:600;transition:0.2s;"
                        onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL RENT --}}
    @if ($showRentForm)
        <div
            style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:999;">
            <div style="background:white;padding:30px;border-radius:20px;max-width:450px;width:90%;position:relative;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
                <button wire:click="closeRentForm"
                    style="position:absolute;top:15px;right:15px;width:32px;height:32px;border-radius:50%;background:#f1f5f9;border:none;cursor:pointer;color:#64748b;display:flex;align-items:center;justify-content:center;transition:0.2s;"
                    onmouseover="this.style.background='#e2e8f0'; this.style.color='#334155'">
                    <i class="bi bi-x-lg"></i>
                </button>
                
                <h2 style="margin:0 0 24px 0;font-size:1.5rem;color:#1e293b;display:flex;align-items:center;gap:10px;">
                    <i class="bi bi-bookmark-star-fill" style="color:#10b981;"></i> Form Pinjam
                </h2>
                
                <form wire:submit.prevent="submitRent">
                    <div style="margin-bottom:16px;">
                        <label style="display:block;font-size:0.85rem;font-weight:600;color:#475569;margin-bottom:6px;">Nama Lengkap</label>
                        <input wire:model.defer="nama" placeholder="Nama" required
                            style="width:100%;padding:12px;border-radius:10px;border:1px solid #cbd5e1;">
                    </div>
                    <div style="margin-bottom:16px;">
                        <label style="display:block;font-size:0.85rem;font-weight:600;color:#475569;margin-bottom:6px;">No Telp</label>
                        <input wire:model.defer="tempat_lahir" placeholder="Nomor Telp" required
                            style="width:100%;padding:12px;border-radius:10px;border:1px solid #cbd5e1;">
                    </div>
                    <div style="margin-bottom:24px;">
                        <label style="display:block;font-size:0.85rem;font-weight:600;color:#475569;margin-bottom:6px;">Alamat Lengkap</label>
                        <textarea wire:model.defer="alamat" placeholder="Jalan, RT/RW, Kelurahan..." required
                            style="width:100%;padding:12px;border-radius:10px;border:1px solid #cbd5e1;height:80px;resize:none;"></textarea>
                    </div>
                    <button type="submit"
                        style="width:100%;padding:14px;border-radius:12px;background:linear-gradient(135deg, #10b981 0%, #059669 100%);color:white;font-weight:600;cursor:pointer;border:none;box-shadow:0 4px 6px -1px rgba(16, 185, 129, 0.3);transition:0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'" 
                        onmouseout="this.style.transform='translateY(0)'">
                        Kirim Permintaan
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL PREVIEW GAMBAR (FIXED: Button tidak terpotong) --}}
    @if ($previewImage)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;z-index:1000;animation: fadeIn 0.3s;">
            
            <!-- CONTAINER UTAMA (GLASSMORPHISM) -->
            <!-- overflow:hidden dihapus agar tombol tidak terpotong. display:flex & height dipindah ke wrapper dalam -->
            <div style="position:relative;max-width:900px;width:90%;background:rgba(255, 255, 255, 0.85);backdrop-filter:blur(15px);border:1px solid rgba(255,255,255,0.3);border-radius:24px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
                
                <!-- WRAPPER KONTEN (Overflow Hidden di sini untuk border radius) -->
                <div style="display:flex;flex-direction:row;max-height:85vh;overflow:hidden;border-radius:24px;">
                    
                    <!-- GAMBAR KIRI -->
                    <div style="width:320px;min-width:320px;flex-shrink:0;background:rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:center;padding:20px;">
                        <img src="{{ $previewImage ? \Illuminate\Support\Facades\Storage::url($previewImage) : 'https://via.placeholder.com/300x400?text=No+Image' }}"
                            style="max-height:80vh;object-fit:contain;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.2);"
                            alt="Preview">
                    </div>
                    
                    <!-- TEKS KANAN -->
                    <div style="flex:1;padding:30px;overflow-y:auto;color:#1e293b;">
                        <h3 style="margin-top:0;font-size:1.5rem;color:#0f172a;border-bottom:2px solid rgba(0,0,0,0.1);padding-bottom:15px;margin-bottom:20px;">
                            <i class="bi bi-book" style="color:#10b981;"></i> Sinopsis
                        </h3>
                        <div style="line-height:1.8;font-size:1.05rem;white-space:pre-wrap;word-wrap:break-word;">
                            {{ $previewSinopsis ?: 'Tidak ada sinopsis tersedia.' }}
                        </div>
                    </div>
                </div>
                <!-- END WRAPPER KONTEN -->

                <!-- CLOSE BUTTON (Siblings dengan Wrapper, Anak dari Container Utama) -->
                <!-- Karena parent tidak punya overflow:hidden lagi, tombol ini tidak akan terpotong -->
                <button wire:click="closeImage"
                    style="position:absolute;top:-15px;right:-15px;background:#ef4444;color:white;border:none;border-radius:50%;width:40px;height:40px;font-size:1.5rem;cursor:pointer;z-index:10;box-shadow:0 4px 10px rgba(239, 68, 68, 0.4);display:flex;align-items:center;justify-content:center;transition:0.2s;"
                    onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    @endif
    
    {{-- CSS ANIMATION KEYFRAMES --}}
    <style>
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom Scrollbar for Modal Text */
        div::-webkit-scrollbar { width: 8px; }
        div::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); }
        div::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 10px; }
        div::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.3); }
    </style>

    {{-- PAGINATION (LIVEWIRE SAFE) --}}
    @if ($books->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $books->links() }}
        </div>
    @endif
</div>