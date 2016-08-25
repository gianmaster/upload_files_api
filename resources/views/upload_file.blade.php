<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
    <script src="js/base64.js"></script>
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
        .content_ajax_form{
            margin-top: 25px;
            padding: 10px;
            border: 1px dashed #585858;
            -webkit-border-radius:10px;
            -moz-border-radius:10px;
            border-radius:10px;
        }
    </style>

    <script>
        var _archivo = null;
        var _ext = null;
        var _contentType= null;


        $(document).ready(function(){

            var ARCHIVOS_PERMITIDOS = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'sql'];


            /**
             * Metodos para tratar el archivos sin usar jQuery
             * @param id
             * @returns {Element}
             * @constructor
            */
            function EL(id) {
                return document.getElementById(id);
            }

            function readFile() {
                if (this.files && this.files[0]) {
                    _contentType = this.files[0].type;
                    var extension = this.files[0].name.split('.').pop().toLowerCase();
                    var isSuccess = ARCHIVOS_PERMITIDOS.indexOf(extension) > -1;
                    if(isSuccess){
                        var FR= new FileReader();
                        FR.onload = function(e) {
                            //console.log(e, e.target);
                            //EL("iframe-content").src       = e.target.result;
                            _archivo = btoa(e.target.result);
                            _ext = extension;
                            //EL("contenido").innerHTML = e.target.result;
                        };
                        FR.readAsBinaryString( this.files[0] );
                        //FR.readAsDataURL(this.files[0]);
                    }else{
                        alert('Archivo no permitido');
                    }

                }
            }

            function init(){
                EL("_file").addEventListener("change", readFile, false);
            }

            $("#send").on('click', function(){
                $.ajax
                ({
                    /*
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
                    },
                    */
                    type: "POST",
                    url: "api/archivos",
                    dataType: 'json',
                    async: false,
                    headers: {
                        "Authorization": "Bearer pfuoSqswV04Ca80E6gD9DqouwPvEgyF6zDEeIzBW"
                    },
                    data: {
                        "client_id": "11111",
                        "referencia": "20160100116172",
                        "tipo": "TEST2",
                        "usuario": "gcercado",
                        "nombre_asignado": "doc_pdf",
                        "extension": _ext,
                        "content_type": _contentType,
                        "nombre_real": "ride_2016.pdf",
                        "archivo_binario": _archivo
                    },
                    success: function (){
                        alert('Se subio el archivos correctamente!');
                    },
                    error: function(e){
                        if (e.status == 401) {
                            alert('La sesion expiro');
                        }else {
                            alert('Se cayo :(');
                        }
                        console.log(e);
                    }
                });
            });

            //INIT
            init();


        });
    </script>
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


        <!--
        <form action="upload" method="post" enctype="multipart/form-data">
            <p>
                <label for="comentario">Comentario</label>
                <input name="comentario" type="text" id="comentario" placeholder="Ingresa una descripción">
            </p>
            <label for="archivo">Archivo</label>
            <input name="archivo" type="file" id="archivo">
            <hr>
            <button type="submit">Enviar</button>
        </form>
        -->


        <div class="content_ajax_form">
            <p>
                <label for="nombre">Nombre</label>
                <input name="nombre" type="text" id="nombre" placeholder="Ingresa una numbre para el archivo">
            </p>
            <label for="_file">Archivo a subir</label>
            <input name="archivo" type="file" id="_file">
            <br>
            <button type="submit" id="send">Enviar</button>
        </div>

            <!--
    <div class="content_iframe">
        <pre id="contenido" style="display: none;"></pre>
        <iframe id="iframe-content" src="" width="500px"></iframe>
    </div>
    -->



</body>
</html>