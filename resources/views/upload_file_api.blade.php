<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Document</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{!! asset('/vendors/bootstrap-3.3.7/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('/vendors/font-awesome-4.6.3/css/font-awesome.min.css') !!}">
    <script src="{{ asset('js/api-view/vue.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.js"></script>

</head>
<body>

<div class="container">
    <div class="row">

        <app-form></app-form>
        <!-- El siguiente div es un template -->
        <div id="app-form">
            <form id="frm" v-on:submit.prevent="uploadFile" method="post">
                <div class="col-xs-12">
                    <div class="alert alert-success alert-dismissible" role="alert"  v-if="success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" v-on:click="toggleAlert">&times;</span></button>
                        <strong>Hecho!</strong> Archivo subido correctamente.
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="form-group">

                        <label for="nombre">Nombre o Descripción</label>
                        <input type="text" class="form-control" v-model="form_data.nombre_asignado" required>
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo" v-model="form_data.tipo" class="form-control" required>
                            <option v-for="item in tipos_archivos" :value="item.abreviatura">@{{item.descripcion}}</option>
                        </select>
                        <label for="archivo">Archivo</label>
                        <input type="file" name="archivo" id="archivo" v-model="file" v-on:change="readFile" class="form-control" required>


                        <!--
                        <pre>@{{ $data | json }}</pre>
                        -->

                    </div>
                </div>

                <div class="col-xs-12">
                    <button v-if="loading" type="submit" class="btn btn-primary pull-right" disabled><i class="fa fa-circle-o-notch fa-spin"></i> SUBIENDO ARCHIVO</button>
                    <button v-else type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-upload"></i> SUBIR ARCHIVO</button>
                </div>

                <!--
                <div class="col-xs-6 col-sm-9">
                    <button class="btn btn-danger" type="reset" v-on:click="closeWindow"><i class="glyphicon glyphicon-remove-sign"></i> CERRAR</button>
                </div>
                -->
            </form>

        </div>

    </div>
</div>


</body>

<script>
    /**
     * Vue es compatible con:
     * Android 4.2 o mayor
     * Firefox 45 o mayor
     * Chrome 51 o mayor
     * IE9 o mayor
     * Iphone 7.0 o mayor
     * Edge 13 o mayor
     * Safari 10.10 o mayor
     */
    (function(){
        /**
         * Set global header
         */
        $.ajaxSetup({
            headers: {
                "Authorization": "Bearer {!! $token !!}"
            }
        });

        new Vue({
            el: "#app-form",
            name: 'upload-file-component',
            ready: function(){
                var that = this;
                $.get("{!! url('/api/catalogos/1/items') !!}").then(function(resp){
                    that.tipos_archivos = resp.data;
                }, function(err){
                    console.log(err);
                })
            },
            data: {
                form_data : {
                    client_id: "{!! $client_id !!}",
                    referencia: "{!! $referencia !!}",
                    tipo: '',
                    usuario: "{!! $username !!}",
                    nombre_asignado: '',
                    extension: '',
                    content_type: '',
                    nombre_real: '',
                    archivo_binario: ''
                },
                file: '',
                loading: false,
                success: false
            },
            methods: {
                resetForm: function(){
                    document.getElementById("frm").reset();
                    this.form_data.archivo_binario = '';
                    this.form_data.tipo = '';
                    this.toggleAlert();
                },
                toggleAlert: function(){
                    this.success = !this.success;
                },
                toggleLoading: function(){
                    this.loading = !this.loading;
                },
                readFile: function(ev){
                    var files = ev.target.files, that = this;
                    if (files && files[0]) {
                        that.form_data.content_type = files[0].type;
                        that.form_data.nombre_real = files[0].name;
                        that.form_data.extension = files[0].name.split('.').pop().toLowerCase();
                        var isSuccess = that.archivos_permitidos.indexOf(that.form_data.extension) > -1;
                        if(isSuccess){
                            var FR= new FileReader();
                            FR.onload = function(e) {
                                that.form_data.archivo_binario = btoa(e.target.result);
                            };
                            FR.readAsBinaryString(files[0] );
                            //FR.readAsDataURL(files[0]);
                        }else{
                            alert('Archivo no permitido');
                        }

                    }
                },
                uploadFile: function(){
                    var that = this;
                    that.toggleLoading();
                    $.ajax({
                        type: 'POST',
                        url: "{!! url('/api/archivos') !!}",
                        dataType: 'json',
                        async: true,
                        data : that.form_data,
                        success: function(resp){
                            //alert('Archivo subido correctamente');
                            that.toggleLoading();
                            that.resetForm();
                        },
                        error: function(err){
                            if(err.status != 409) {
                                alert('Error. No se pudo subir el archivo');
                                that.toggleLoading();
                                console.log(err);
                            }else{
                                if(confirm(err.responseJSON.message + '. Aceptar para reemplazar')) {
                                    $.ajax({
                                        type: 'PUT',
                                        url: "{!! url('/api/archivos') !!}/" + err.responseJSON.id,
                                        dataType: 'json',
                                        async: true,
                                        data: that.form_data,
                                        success: function (resp) {
                                            //alert('Archivo reemplazado correctamente!');
                                            that.toggleLoading();
                                            that.resetForm();
                                        },
                                        error: function (err) {
                                            alert('ERROR. No se pudo realizar la actualización');
                                            console.log(err);
                                            that.toggleLoading();
                                        }
                                    });
                                }else{
                                    that.toggleLoading();
                                }
                            }
                        }
                    })
                }
            },
            props: {
                archivos_permitidos: {
                    type: Array,
                    default: function(){
                        return ['pdf'];//['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt'];
                    }
                },
                tipos_archivos: {
                    type: Array,
                    default: function (){
                        return [{value: 1, text: ''}];
                    }
                }
            }
        });
    })();
</script>

</html>

