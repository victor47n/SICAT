@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
<h1>Ordens de serviço</h1>
@stop

@section('breadcrumb')
<li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
<li class="breadcrumb-item active">Ordens de serviço</li>
<li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
<div class="row  justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Cadastrar Ordens de serviço</h3>
            </div>

            <form id="form">
                {{ csrf_field() }}

                <div class="card-body">
                    <div class="row">
                        <div class="form-group  col-md-12">
                            <label for="name">Descrição</label>
                            <input type="text" class="form-control" id="problem" name="problem" placeholder="Nome">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">Problema</label>
                            <select class="form-control" id="problem" name="problem">
                                <option value="" selected disabled hidden>Selecione</option>
                                <option value="Software">Software</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Sistema Operacional">Sistema Operacional</option>
                                <option value="Rede">Rede</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Local</label>
                            <select class="form-control" id="locale" name="locale">
                                @foreach ($locales as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Posto de Trabalho</label>
                            <select class="form-control" id="workstation" name="workstation">

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Posto de Trabalho</label>
                            <input type="date" class="form-control" name="realized_date" id="realized_date">
                            </select>
                        </div>
                    </div>
                </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
        </form>
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
            var a = 0;

            $("#form").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('locale.store')}}",
                    method: "POST",
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