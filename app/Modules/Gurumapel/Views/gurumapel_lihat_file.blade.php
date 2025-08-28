<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="{{ url('uploads/'.$jenis.'/'.$file) }}">Klik untuk download file ini.</a>
    <iframe
    src="https://docs.google.com/gview?url={{ url('uploads/'.$jenis.'/'.$file) }}&embedded=true&toolbar=1"
    style="width: 100%; 
    height: 600px">
    <p>Your browser does not support iframes.</p>
</iframe>
</body>
</html>
    {{-- <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ url('uploads/'.$jenis.'/'.$file) }}" frameborder="0" width="800px" style="width:100%;min-height:940px;"></iframe> --}}

