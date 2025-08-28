<table  class="table">
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>Kelas</td>
    </tr>
    @php
        $no = 1;
    @endphp
    @foreach ($siswa as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->nama_siswa }}</td>
            <td>{{ $item->kelas }}</td>
        </tr>
        
    @endforeach
   
</table>