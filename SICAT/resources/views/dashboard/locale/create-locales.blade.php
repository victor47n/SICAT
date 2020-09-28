@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Postos de Trabalho</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Postos de Trabalho</li>
    <li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
    <div class="row  justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar Postos de Trabalho</h3>
                </div>

                <form id="lForm">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <h4 class="text-bold text-left mb-4">Local</h4>
                        <div class="form-group">
                            <label for="name">Nome do local</label>
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="Nome">
                        </div>

                        <h4 class="text-bold text-left mb-4 mt-4">Salas</h4>
                        <div id="rooms">
                            <div id="room-row" class="form-row mb-4 mb-md-0">
                                <div class="form-group col-sm-12 col-md-10">
                                    <input type="text" class="form-control" id="room" name="room[]"
                                           placeholder="Nome da sala">
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <button id="delete" type="button" class="btn btn-danger btn-block"><i
                                            class="fas fa-fw fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button id="addRoom" type="button" class="btn btn-info">Adicionar sala</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <div class="float-right d-none d-sm-inline">
        <strong>Versão</strong> 1.0
    </div>
    <strong>Copyright &copy; {{date("Y")}} <a href="#">Carlos A. & Victor H</a>.</strong> Todos os direitos reservados.
@stop

@section('css')
@stop

@section('plugins.Validation', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#lForm').validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "O campo nome é obrigatório.",
                },
            },

            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });


        $(document).ready(function () {
            const fieldSala = $("#room-row").clone(true, true);
            let a = 0;

            $("div").on('click', '#delete', function () {
                $(this).parents()[1].remove();
            });

            $("#addRoom").on('click', function () {
                a++;

                let html = '<div id="room-row-'+a+'" class="form-row mb-4 mb-md-0">' +
                            '<div class="form-group col-sm-12 col-md-10">' +
                                '<input type="text" class="form-control" id="room-'+a+'" name="room[]" placeholder="Nome da sala">' +
                            '</div>' +
                            '<div class="col-xs-12 col-md-2">' +
                                '<button id="delete" type="button" class="btn btn-danger btn-block"><i class="fas fa-fw fa-times"></i></button>' +
                            '</div>' +
                        '</div>';

                $("#rooms").append(html);
            });

            $("#lForm").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('locale.store')}}",
                    method: "POST",
                    dataType: 'json',
                    data: $('#lForm').serialize(),
                    success: function (data) {
                        $('#inputName').val('');
                        $('#room').val('');
                        const rooms = $('#rooms');
                        let children = rooms.children().length
                        for (let i = children; i > 0; i--) {
                                rooms.children().eq(i).remove();
                        }
                        Toast.fire({
                            type: 'success',
                            title: data.message
                        });
                    },
                    error: function (error) {
                        Swal.fire({
                            type: 'error',
                            title: 'Algo de errado aconteceu!',
                            text: error.responseJSON.message
                        });
                    }
                });
            });
        });
    </script>

@stop
