<div class="row">
    <nav aria-label="Page navigation example" style="margin-left: 40px; padding-right: 90px; width: 100%;">
        <ul class="pagination pagination-sm flex-wrap">
            @for ($i = 1; $i <= $ujian->jml_soal; $i++)
                <li class="page-item @isset ($soal_terinput[$i])
                    active
                @endisset"><a @if ($no_soal == $i)
                    style="background-color: red; color: white;"
                @endif class="page-link" href="{{ route('soal.input_soal.create', [$id_ujian, $id_jenissoal, $i]) }}">{{ $i }}</a></li>
            @endfor
          
        </ul>
      </nav>
</div>