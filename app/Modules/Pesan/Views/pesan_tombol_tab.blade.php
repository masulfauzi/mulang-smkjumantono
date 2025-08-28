<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link 
            @if(Route::currentRouteName() == 'pesan.create') active @endif" 
            id="detail_kps-tab" href="{{ route('pesan.create') }}"
            role="tab" aria-controls="detail_kps" aria-selected="true">Nomor</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link 
            @if(Route::currentRouteName() == 'pesan.banyak_nomor.create') active @endif" 
            id="detail_kps-tab" href="{{ route('pesan.banyak_nomor.create') }}"
            role="tab" aria-controls="detail_kps" aria-selected="true">Banyak Nomor</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link
            @if(Route::currentRouteName() == 'pesan.semua_siswa.create') active @endif" 
            id="detail_kps-tab" href="{{ route('pesan.semua_siswa.create') }}" role="tab"
            aria-controls="detail_kps" aria-selected="true">Semua Siswa</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="daftar_kups-tab" data-bs-toggle="tab" href="#daftar_kups" role="tab"
            aria-controls="daftar_kups" aria-selected="false">Fitur Baru</a>
    </li>
</ul>