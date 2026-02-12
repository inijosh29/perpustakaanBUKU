<div style="background-color: #f8fafc; min-height: 100vh; padding: 40px 20px; font-family: 'Inter', system-ui, -apple-system, sans-serif;">
    
    <div style="max-width: 1200px; margin: auto;">
        
        <header style="text-align: center; margin-bottom: 60px;">
            <h1 style="
                font-size: 56px;
                font-weight: 900;
                margin-bottom: 10px;
                letter-spacing: -2px;
                background: linear-gradient(135deg, #1e293b 0%, #059669 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-family: 'Times New Roman', Times, serif;
            ">
                Daftar Pinjam
            </h1>
            <div style="width: 60px; height: 5px; background: #10b981; margin: auto; border-radius: 10px; box-shadow: 0 4px 12px rgba(16,185,129,0.3);"></div>
        </header>

        {{-- BOOTSTRAP ALERT (LOGIC TETAP) --}}
        @if(session()->has('success'))
            <div style="background: #ecfdf5; border-left: 5px solid #10b981; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <span style="font-size: 20px;">✅</span>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
        @endif

        @if(session()->has('error'))
            <div style="background: #fef2f2; border-left: 5px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <span style="font-size: 20px;">⚠️</span>
                <span style="font-weight: 600;">{{ session('error') }}</span>
            </div>
        @endif

        {{-- RENTAL CARDS GRID --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px;">
            @foreach($rentals as $rental)
                <div style="
                    background: white;
                    border-radius: 24px;
                    border: 1px solid #f1f5f9;
                    overflow: hidden;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                " 
                onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.05)';"
                >
                    <div style="padding: 24px 24px 10px 24px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="
                            padding: 6px 14px; 
                            border-radius: 10px; 
                            font-size: 11px; 
                            font-weight: 800; 
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            background: {{ $rental->status === 'approved' ? '#eff6ff' : '#ecfdf5' }};
                            color: {{ $rental->status === 'approved' ? '#2563eb' : '#059669' }};
                        ">
                            ● {{ $rental->status }}
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: #94a3b8; background: #f8fafc; padding: 4px 10px; border-radius: 8px;">
                            {{ $rental->category }}
                        </span>
                    </div>

                    <div style="padding: 0 24px 24px 24px; flex-grow: 1;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #1e293b; margin: 10px 0 15px 0; line-height: 1.3;">
                            {{ $rental->book->title }}
                        </h3>
                        
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                            <div style="width: 32px; height: 32px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b;">
                                👤
                            </div>
                            <span style="font-weight: 600; color: #475569; font-size: 14px;">{{ $rental->user->name }}</span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; background: #f8fafc; border-radius: 16px; padding: 15px; gap: 10px;">
                            <div>
                                <p style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Pinjam</p>
                                <p style="font-size: 13px; font-weight: 700; color: #334155; margin: 0;">{{ \Carbon\Carbon::parse($rental->rented_at)->format('d M Y') }}</p>
                            </div>
                            <div style="border-left: 1px dashed #cbd5e1; padding-left: 15px;">
                                <p style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin: 0 0 4px 0;">Kembali</p>
                                <p style="font-size: 13px; font-weight: 700; color: {{ $rental->returned_at ? '#334155' : '#ef4444' }}; margin: 0;">
                                    {{ $rental->returned_at ? \Carbon\Carbon::parse($rental->returned_at)->format('d M Y') : 'Belum' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON KEMBALIKAN (LOGIC TETAP) --}}
                    @if($rental->status === 'approved')
                        <div style="padding: 0 24px 24px 24px;">
                            <button
                                wire:click="returnBook({{ $rental->id }})"
                                style="
                                    width: 100%;
                                    background: #2563eb;
                                    color: white;
                                    font-weight: 700;
                                    padding: 12px;
                                    border-radius: 14px;
                                    border: none;
                                    cursor: pointer;
                                    transition: all 0.2s;
                                    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    gap: 8px;
                                "
                                onmouseover="this.style.background='#1d4ed8'; this.style.transform='scale(1.02)';"
                                onmouseout="this.style.background='#2563eb'; this.style.transform='scale(1)';"
                            >
                                🔄 Kembalikan Buku
                            </button>
                        </div>
                    @else
                        <div style="padding: 0 24px 24px 24px; text-align: center;">
                            <div style="color: #059669; font-size: 13px; font-weight: 700; background: #f0fdf4; padding: 10px; border-radius: 12px; border: 1px dashed #bbf7d0;">
                                ✨ Sudah Dikembalikan
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- EMPTY STATE (LOGIC TETAP) --}}
        @if($rentals->count() === 0)
            <div style="text-align: center; padding: 100px 20px; background: white; border-radius: 30px; border: 2px dashed #e2e8f0; margin-top: 40px;">
                <div style="font-size: 60px; margin-bottom: 20px;">📭</div>
                <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 8px;">Belum Ada Aktivitas</h3>
                <p style="color: #64748b; font-size: 15px;">Semua data pinjam Anda akan muncul di sini nanti.</p>
            </div>
        @endif

        {{-- PAGINATION (LOGIC TETAP) --}}
        @if ($rentals->hasPages())
            <div style="margin-top: 50px; padding: 25px; background: white; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="color: #64748b; font-size: 14px; font-weight: 500;">
                    Menampilkan 
                    <span style="color: #1e293b; font-weight: 700;">{{ $rentals->firstItem() }}</span> – 
                    <span style="color: #1e293b; font-weight: 700;">{{ $rentals->lastItem() }}</span> 
                    dari 
                    <span style="color: #1e293b; font-weight: 700;">{{ $rentals->total() }}</span> data
                </div>
                <div>
                    {{ $rentals->links() }}
                </div>
            </div>
        @endif

    </div>
</div>