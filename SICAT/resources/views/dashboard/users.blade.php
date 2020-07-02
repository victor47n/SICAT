@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Funcionários</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('welcome')}}>Home</a></li>
    <li class="breadcrumb-item active">Funcionários</li>
    <li class="breadcrumb-item active">Listar</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tUsers" class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nome</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Email</th>
                            <th class="sorting" tabindex="0">Opções</th>
                        </tr>
                        </thead>
                    </table>
                </div>
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

@section('plugins.Datatables', true)

@section('js')
    <script>
        $(document).ready(function () {
            var table = $('#tUsers');
            table.DataTable({
                "ajax": '{{ route('user.show') }}',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                },
                "searching": true,
                // "columnDefs": [
                //     {"name": "Nome", "targets": 0,},
                //     {"name": "Email", "targets": 1},
                //     {"name": "Opções", "targets": 2},
                // ],
                "columns": [
                    {"data": "name"},
                    {"data": "email"},
                ],
            });
        });
    </script>
@stop
