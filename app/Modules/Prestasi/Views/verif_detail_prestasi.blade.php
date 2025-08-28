<div class="row">
    <div class="col-6">
        <table>
            <tr>
                <th>Nama Prestasi</th>
                <td>{{ $prestasi->prestasi }}</td>
            </tr>
            <tr>
                <th>Juara</th>
                <td>{{ $prestasi->juara->juara }}</td>
            </tr>
            <tr>
                <th>Tanggal Perolehan</th>
                <td>{{ \App\Helpers\Format::tanggal($prestasi->tgl_perolehan) }}</td>
            </tr>
            <tr>
                <th>Sertifikat</th>
                <td>
                    <p>Jika gambar tidak keluar silahkan <a target="_blank"
                            href="{{ url('uploads/sertifikat_prestasi/' . $prestasi->sertifikat) }}">Download</a></p>
                    <img src="{{ url('uploads/sertifikat_prestasi/' . $prestasi->sertifikat) }}" width="400px;"
                        alt="Bukti Prestasi">
                </td>
            </tr>
        </table>
    </div>
    <div class="col-6">
        <form action="{{ route('prestasi.verif_prestasi.store') }}" class="form form-horizontal" method="POST">
            <input type="hidden" name="id_prestasi" value="{{ $prestasi->id }}">
            <div class="form-body">
                @csrf
                <div class="row">
                    <div class="col-md-3 text-sm-start text-md-end pt-2">
                        <label>Dipakai?</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input @if ($prestasi->is_pakai == 1) @checked(true) @endif type="radio"
                            name="is_pakai" value="1" required> Dipakai
                        <br>
                        <input @if ($prestasi->is_pakai == 0) @checked(true) @endif type="radio"
                            name="is_pakai" value="0" required> Tidak Dipakai
                        @error('juara')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-sm-start text-md-end pt-2">
                        <label>Juara</label>
                    </div>
                    <div class="col-md-9 form-group">
                        {{ Form::select('id_juara', $ref_juara, $prestasi->id_juara, ['class' => 'form-control select2', 'required' => '']) }}
                        @error('juara')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="offset-md-3 ps-2">
                    <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                </div>
            </div>
        </form>
    </div>
</div>
