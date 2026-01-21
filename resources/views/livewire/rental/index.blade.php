<div style="max-width:1100px;margin:auto;padding:25px;color:black;">

    <h1 style="
    font-size:64px;
    font-weight:900;
    margin-bottom:64px;
    text-align:center;
    letter-spacing:1px;
    background:linear-gradient(90deg,#000000,#22c55e);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    text-shadow:0 6px 18px rgba(22,163,74,.25);
    position:relative;
    font-family:'Times New Roman', Times, serif
">
    Daftar Rental

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

    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div id="flash-success"
            style="background:#16a34a;color:white;
                padding:14px 20px;border-radius:12px;
                margin-bottom:20px;
                box-shadow:0 10px 20px rgba(0,0,0,.15);
                transition:opacity .5s ease, transform .5s ease;">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (el) {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    @if(session()->has('error'))
        <div id="flash-error"
            style="background:#dc2626;color:white;
                padding:14px 20px;border-radius:12px;
                margin-bottom:20px;
                box-shadow:0 10px 20px rgba(0,0,0,.15);
                transition:opacity .5s ease, transform .5s ease;">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-error');
                if (el) {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    {{-- Rental Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(420px,1fr));gap:20px;">
        @foreach($rentals as $rental)
            <div
                style="background:white;border-radius:18px;padding:20px;
                    box-shadow:0 15px 30px rgba(0,0,0,.08);
                    transition:.25s;"
                onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 25px 40px rgba(0,0,0,.15)'"
                onmouseout="this.style.transform='none';this.style.boxShadow='0 15px 30px rgba(0,0,0,.08)'"
            >
                <div style="display:flex;justify-content:space-between;gap:15px;">
                    <div>
                        <div style="font-size:18px;font-weight:800;margin-bottom:5px;">
                            {{ $rental->book->title }}
                        </div>
                        <div style="color:#374151;">👤 {{ $rental->user->name }}</div>
                        <div style="margin-top:6px;">
                            <span style="background:#e0f2fe;color:#0369a1;
                                padding:6px 14px;border-radius:999px;
                                font-size:12px;font-weight:700;">
                                {{ $rental->category }}
                            </span>
                        </div>
                    </div>

                    <div style="text-align:right;font-size:13px;color:#6b7280;">
                        <div>📅 Pinjam:<br>
                            <b>{{ \Carbon\Carbon::parse($rental->rented_at)->format('d M Y H:i') }}</b>
                        </div>
                        <div style="margin-top:6px;">📦 Kembali:<br>
                            <b>
                                {{ $rental->returned_at
                                    ? \Carbon\Carbon::parse($rental->returned_at)->format('d M Y H:i')
                                    : '-' }}
                            </b>
                        </div>

                        <div style="margin-top:10px;font-weight:800;color:
                            {{ $rental->status === 'rented' ? '#2563eb' : '#16a34a' }};">
                            {{ strtoupper($rental->status) }}
                        </div>
                    </div>
                </div>

                @if($rental->status === 'rented')
                    <div style="margin-top:18px;text-align:right;">
                        <button
                            wire:click="returnBook({{ $rental->id }})"
                            style="background:#2563eb;color:white;font-weight:700;
                                padding:10px 22px;border-radius:14px;
                                border:none;cursor:pointer;transition:.2s;"
                            onmouseover="this.style.background='#1d4ed8'"
                            onmouseout="this.style.background='#2563eb'"
                        >
                            🔄 Kembalikan Buku
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if($rentals->count() === 0)
        <div style="text-align:center;margin-top:40px;color:#6b7280;font-size:16px;">
            📭 Belum ada aktivitas rental.
        </div>
    @endif

    {{-- PAGINATION + Showing Info --}}
    @if ($rentals->hasPages())
        <div style="margin-top:30px; display:flex; justify-content:space-between; align-items:center; gap:60px;">

            {{-- Showing Info --}}
            <div style="color:#6b7280; font-size:14px;">
                Menampilkan
                <b>{{ $rentals->firstItem() }}</b> hingga
                <b>{{ $rentals->lastItem() }}</b> dari
                <b>{{ $rentals->total() }}</b> data
            </div>

            {{-- Pagination Links --}}
            <div>
                {{ $rentals->links() }}
            </div>
        </div>
    @endif

</div>
