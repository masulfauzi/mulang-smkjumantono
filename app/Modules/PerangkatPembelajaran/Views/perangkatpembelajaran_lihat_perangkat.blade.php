<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Lihat Perangkat Pembelajaran</title>
  </head>
  <body>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
              <h5>Data Perangkat Pembelajaran</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive-md col-12">
                <form class="form form-horizontal" action="{{ route('perangkatpembelajaran.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                        @csrf 
                       
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Guru</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <div class="form-control">{{ $data->guru['nama'] }}</div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Mapel</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <div class="form-control">{{ $data->mapel['mapel'] }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Kelas</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <ul>
                                    @foreach ($mapel as $item_mapel)
                                        <li>{{ $item_mapel->kelas }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        
                  </div>
                </form>
            </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="card-header">
              <h5>Perangkat Pembelajaran yang Terupload</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive-md col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perangkat</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($perangkat as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_perangkat }}</td>
                                <td>{{ $item->jenisPerangkat['jenis_perangkat'] }}</td>
                                <td>
                                    <a class="btn btn-primary" target="_blank" href="{{ route('perangkatpembelajaran.detail.index', $item->id) }}">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
          </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>