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
                <h3 class="card-title">Cadastrar ordem de serviço</h3>
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
                            <select class="form-control" id="problem_type" name="problem_type">
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
                            <select class="form-control" id="locale_id" name="locale_id">
                                <option value="" selected disabled hidden>Selecione</option>

                                @foreach ($locales as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Posto de Trabalho</label>
                            <select class="form-control" disabled id="workstation_id" name="workstation_id">

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">Data</label>
                            <input type="date" class="form-control" name="realized_date" id="realized_date">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Funcionário designado</label>
                            <select class="form-control" id="designated_employee" name="designated_employee">
                                @foreach ($funcionarios as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Status</label>
                            <select class="form-control" id="status_id" name="status_id">
                                <option value="5">Pendente</option>
                                <option value="4">Finalizado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
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
            var a = 0;
            var data = new Date();

            $("#realized_date").val(`${data.getFullYear()}-${("0"+(data.getMonth()+1)).slice(-2)}-${("0"+data.getDate()).slice(-2)}`)

            $("#locale_id").change(function(e){
                e.preventDefault();
                $.ajax({
                    url: `/locais/${$("#locale_id").val()}/workstations`,
                    method: "GET",
                    dataType: 'json',
                    data: $('#form').serialize(),
                    success: function (data) {
                        console.log(data);
                        workstations = data.data;
                        $("#workstation_id").html("").removeAttr("disabled");

                        workstations.forEach(element => {
                            $("#workstation_id").append(`<option value="${element.id}">${element.name}</option>`)
                        });
                    }
                });
            });

            $("#form").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{route('order.store')}}",
                    method: "POST",
                    dataType: 'json',
                    data: $('#form').serialize(),
                    success: function (data) {
                        console.log(data);
                        Toast.fire({
                            type: 'success',
                            title: data.message
                        });
                    },
                    error:function(data){
                        console.log(data);
                        Toast.fire({
                            type: 'error',
                            title: data.message
                        });
                    }
                });
            });
        });
</script>

@stop