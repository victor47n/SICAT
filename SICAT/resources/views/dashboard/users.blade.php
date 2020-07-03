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
                <div class="card-header">
                    <h3 class="card-title">Cadastros de funcionários</h3>
                </div>
                <div class="card-body">
                    <table id="tUsers" class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc">Nome</th>
                            <th class="sorting">Email</th>
                            <th class="sorting" >Opções</th>
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
            var table = $('#tUsers').DataTable({
                "ajax": '{{ route('user.show') }}',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json",
                },
                "searching": true,
                "autoWidth": false,
                "responsive": true,
                // "columnDefs": [
                //     {"name": "Nome", "targets": 0,},
                //     {"name": "Email", "targets": 1},
                //     {"name": "Opções", "targets": 2},
                // ],
                "columns": [
                    {"data": "name"},
                    {"data": "email"},
                    {"data": null,
                        "className": "text-center",
                        "defaultContent": '<div class="btn-group btn-group-sm" role="group" aria-label="Exemplo básico">' +
                            '<button type="button" class="btn btn-secondary"><i class="fas fa-edit"></i></button>' +
                            '<button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>' +
                            '</div>',
                    }
                ],
                drawCallback: function () {
                    $('#tUsers_paginate ul.pagination').addClass("justify-content-start");
                }
            });

        });
    </script>
@stop
