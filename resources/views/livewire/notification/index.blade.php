<div x-data="{ open: false }" 
     @open-drawer.window="open = true"
     @keydown.escape.window="open = false"
     class="contents"> {{-- Menggunakan contents agar div pembungkus tidak merusak layout --}}

    {{-- Overlay: Gunakan fixed inset-0 agar menutupi seluruh layar --}}
    <template x-teleport="body"> {{-- Teleport memindahkan modal ke luar header agar tidak terpotong --}}
        <div x-show="open" class="fixed inset-0 z-[999]" style="display: none;">
            
            {{-- Background Backdrop --}}
            <div x-show="open" 
                 x-transition.opacity 
                 class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" 
                 @click="open = false"></div>

            {{-- Panel Drawer: Pastikan h-screen (tinggi penuh layar) --}}
            <div x-show="open"
                 wire:ignore.self
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="absolute inset-y-0 right-0 w-full max-w-sm border-l border-slate-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 flex flex-col h-screen">
                
                {{-- Header Modal --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-800/50">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white leading-tight">Notifikasi</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400">Informasi aktivitas terbaru Anda</p>
                    </div>
                    <button @click="open = false" class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 transition-all dark:hover:bg-gray-800">
                        <flux:icon.x-mark class="w-5 h-5" />
                    </button>
                </div>

                {{-- List Notifikasi: flex-1 agar memenuhi sisa layar --}}
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-white dark:bg-gray-900">
                    @forelse ($notifications as $notif)
                        <div wire:click="markAsReadAndRedirect({{ $notif->id }})"
                            class="group relative flex gap-4 px-6 py-5 border-b border-slate-50 dark:border-gray-800 cursor-pointer transition-all hover:bg-emerald-50/40 dark:hover:bg-emerald-900/10 {{ $notif->is_read ? 'opacity-60' : '' }}">
                            
                            {{-- Dot Belum Dibaca --}}
                            @if(!$notif->is_read)
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                            @endif

                            <div class="flex-shrink-0 ml-2">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-gray-800 text-slate-500 {{ !$notif->is_read ? 'text-emerald-600 bg-emerald-100 dark:bg-emerald-900/30' : '' }}">
                                    <flux:icon.bell class="w-5 h-5" />
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm leading-snug mb-1 {{ $notif->is_read ? 'text-slate-500' : 'font-semibold text-slate-800 dark:text-slate-200' }}">
                                    {{ $notif->message }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full p-10 text-center">
                            <flux:icon.bell-slash class="w-12 h-12 text-slate-200 mb-4" />
                            <h3 class="text-slate-900 dark:text-white font-semibold">Tidak ada notifikasi</h3>
                            <p class="text-sm text-slate-500">Anda sudah membaca semua pesan.</p>
                        </div>
                    @endforelse
                </div>
                
                {{-- Footer: Selalu di bawah --}}
                <div class="p-4 border-t border-slate-100 dark:border-gray-800 bg-white dark:bg-gray-900">
                    @if($notifications->where('is_read', false)->count() > 0)
                    @else
                        <div class="py-3 text-center text-xs font-medium text-slate-400 italic">
                            Semua pesan telah dibaca
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </template>
</div>