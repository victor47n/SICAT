@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
<h1>Postos de Trabalho</h1>
@stop

@section('breadcrumb')
<li class="breadcrumb-item"><a href={{route('welcome')}}>Home</a></li>
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

            <form id="form">
                {{ csrf_field() }}

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome">
                    </div>
                    <h3>Salas </h3>
                    <div id="sala-row" class="form-row">

                        <div class="form-group col-10">
                            <input type="text" class="form-control" id="sala[]" name="sala[]"
                                placeholder="Nome da sala">
                        </div>
                        <div class="col-auto">
                            <button id="delete" type="button" class="btn btn-danger">X</button>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button id="addSala" type="button" class="btn btn-info">Adicionar sala</button>
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

@section('plugins.Sweetalert2', true)

@section('js')
<script>
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function(){
            const fieldSala = $("#sala-row").clone(true,true);
            var a = 0;

            $("div").on('click','#delete',function(){
                console.log( $("#delete").parents());
                $(this).parents()[1].remove();
            });
           
            $("#addSala").on('click',function(){
                console.log(fieldSala);
                a++;
                let t = fieldSala.clone(true,true);
                t.attr('id','sala-row'+a)

               $(".card-body").append(t);
            });
            
            $("#form").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('locale.add')}}",
                    method: "POST",
                    contentType: 'application/json',
                    dataType: 'json',
                    data: $('#form').serialize(),
                    success: function (data) {
                        console.log(data);
                        Toast.fire({
                            type: 'success',
                            title: data.message
                        });
                    }
                });
            });
        });
</script>

@stop