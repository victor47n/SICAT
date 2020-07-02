@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Funcionários</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="tUsers" class="table table-hover">
                    <thead>
                        <td>Nome</td>
                        <td>E-mail</td>
                    </thead>
                    <tr>
                        <td>Carlos</td>
                        <td>carlos.xavier@gmail.com</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
@stop

@section('plugins.Datatables', true)

@section('js')
<script>
    console.log('Hi!'); 
</script>

<script>
    $(document).ready( function () {
        $('#tUsers').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        }
        });
    } );
</script>
@stop