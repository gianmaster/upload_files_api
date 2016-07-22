<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <style>
        body{
            padding: 20px;
            display: block;
        }
        .message-success{
            padding: 10px;
            vertical-align: bottom;
            background: #7ec175;
            color: whitesmoke;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>


        @if(session()->has('success'))
            <div class="message-success">
                <p>
            <strong>{!! session('success') !!}</strong>
                </p>
            </div>
        @else
            <strong>No se ha subido archivo</strong>
        @endif


<form action="upload" method="post" enctype="multipart/form-data">
    <label for="archivo">Archivo</label>
    <input name="archivo" type="file" id="archivo">
    <hr>
    <button type="submit">Enviar</button>
</form>

</body>
</html>