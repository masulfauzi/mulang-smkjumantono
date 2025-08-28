<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download File Ijazah SMP</title>
    <style>
        .center{
            text-align: center;
        }
        hr.atas{
            border-top: 3px solid black;
        }
        hr.bawah{
            border_top: 1px solid black;
            margin-top: -8px;
        }
        .bold{
            font-weight: bold;
        }
        .underline{
            text-decoration: underline;
        }
        .page_break { 
            page-break-before: always; 
        }
        .rotate90 {
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
        }

    </style>
</head>
<body>
    @foreach ($data as $item)
        @php
            $cek_pdf = pathinfo($item->file_ijazah_smp, PATHINFO_EXTENSION);
            $cek_pdf_akta = pathinfo($item->file_akta_lahir, PATHINFO_EXTENSION);

            


            // dd($orientation);


        @endphp

        @if ($cek_pdf == 'jpg' OR $cek_pdf == 'jpeg' or $cek_pdf == 'png')
            @php
                list($width, $height) = getimagesize('uploads/ijazah/'.$item->file_ijazah_smp);
    
                if( $width > $height)
                    $orientation = "rotate90";
                else
                    $orientation = "";
            @endphp

            <img class="{{ $orientation }}" width="100%" src="{{ url('uploads/ijazah/'.$item->file_ijazah_smp) }}" alt="">
            <div class="page_break"></div>
        @endif

        @if ($cek_pdf_akta == 'jpg' OR $cek_pdf == 'jpeg' or $cek_pdf == 'png')
            @php
                list($width, $height) = getimagesize('uploads/akta/'.$item->file_akta_lahir);
    
                if( $width > $height)
                    $orientation = "rotate90";
                else
                    $orientation = "";
            @endphp

            <img class="{{ $orientation }}" width="100%" src="{{ url('uploads/akta/'.$item->file_akta_lahir) }}" alt="">
            <div class="page_break"></div>
        @endif
    @endforeach
</body>
</html>