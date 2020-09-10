@extends('adminlte::page')

@section('title', 'Ordens de serviço')

@section('content_header')
<h1>Ordens de serviço</h1>
@stop

@section('breadcrumb')
<li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
<li class="breadcrumb-item active">Ordens de serviço</li>
<li class="breadcrumb-item active">Listar</li>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ordens de serviço cadastradas</h3>
            </div>
            <div class="card-body">
                <table id="tOS" class="table table-hover table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting">Descrição</th>
                            <th class="sorting">Data de criação</th>
                            <th class="sorting">Data de solução</th>
                            <th class="sorting">Funcionário</th>
                            <th class="sorting">Local</th>
                            <th class="sorting">Estado</th>
                            <th class="sorting">Opções</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal visualizar -->
<div class="modal fade" id="modalVisualizar" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Visualizar ordem de serviço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group  col-md-12">
                        <label for="name">Descrição</label>
                        <input disabled type="text" class="form-control" id="problem" name="problem" placeholder="Nome">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="name">Problema</label>
                        <input disabled type="input" class="form-control" id="problem_type">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Local</label>
                        <input disabled type="input" class="form-control" id="local">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Posto de Trabalho</label>
                        <input disabled type="input" class="form-control" id="workstation">

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="name">Data</label>
                        <input disabled type="date" class="form-control" name="realized_date" id="realized_date">
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Funcionário designado</label>
                        <input disabled type="input" class="form-control" id="designated">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Status</label>
                        <input disabled type="input" class="form-control" id="status">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal -->

<!-- Modal editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Atualizar ordem de serviço </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formConcluido">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group  col-md-12">
                            <label for="name">Descrição</label>
                            <input disabled type="text" class="form-control" id="problem_type" name="problem_type"
                                placeholder="Nome">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">Problema</label>
                            <input disabled type="input" class="form-control" id="problem">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Local</label>
                            <input disabled type="input" class="form-control" id="local">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Posto de Trabalho</label>
                            <input disabled type="input" class="form-control" id="workstation">

                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">Data</label>
                            <input disabled type="date" class="form-control" name="realized_date" id="realized_date">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Funcionário designado</label>
                            <select class="form-control" id="designated_employee" name="designated_employee">
                                <option></option>
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
                        <div class="form-group col-md-12">
                            <label for="name">Realizado por:</label>
                            <select class="form-control" id="solver_employee" name="solver_employee">
                                @foreach ($funcionarios as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Solução: </label>
                            <textarea type="text" class="form-control" id="solution_problem" name="solution_problem"
                                placeholder="Solução">
                        </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="updateButton">Salvar mudanças</button>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal -->


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
@section('plugins.Sweetalert2', true)

@section('js')
<script>
    $(document).ready(function () {
        $.fn.dataTable.moment( 'HH:mm MMM D, YY' );

        var table = $('#tOS');
        table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                language: {
                    // url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json',
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Mostrar _MENU_ itens",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar:",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "_": "Selecionado %d linhas",
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha"
                        }
                    },
                    "buttons": {
                        "copyTitle": "Cópia bem sucedida",
                        "copySuccess": {
                            "1": "Uma linha copiada com sucesso",
                            "_": "%d linhas copiadas com sucesso"
                        }
                    },
                },
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-fw fa-copy"></i>Copiar',
                        titleAttr: 'Copiar',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-fw fa-file-excel"></i>Excel',
                        titleAttr: 'Exportar Excel',
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-fw fa-file-pdf"></i>PDF',
                        titleAttr: 'Exportar PDF',
                    },
                ],
                dom: 'B<"row mt-3" <"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row mt-3" <"col-sm-12 col-md-5" i><"col-sm-12 col-md-7" p>>',
                ajax: {
                    url: '{{ route('order.index') }}',
                },
                columns: [
                     
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'problem',
                        name: 'problem'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'realized_date',
                        name: 'realized_date',
                    },
                    {
                        data: 'designated',
                        name: 'designated'
                    },
                    {
                        data: 'locale',
                        name: 'locale',
                        render: function(data,type,row,meta){
                            return row.locale+" - "+row.workstation
                        }
                    },
                    {
                        data: 'status',
                        name: 'Estado',
                        render: function( data, type, row, meta ){
                            console.log(row);
                            if(row.deleted_at != null){
                                return "Cancelado";
                            }else{
                                return data;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'opções',
                        searchable: false,
                        orderable: false,
                        exportable: false,
                        printable: false,
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        visible: false,
                    }
                ],
                drawCallback: function () {
                    $('#tOS tbody tr td:last-child').addClass('text-center');
                    $('#tOS_paginate ul.pagination').addClass("justify-content-start");
                }
        });
        
        $("#updateButton").on("click", function(){
            $.ajax({
                url: "ordens/"+$("#modalEditar #id").val(),
                method: 'PUT',
                data: $("#modalEditar #formConcluido").serialize(),
                success: function (data) {
                    Swal.fire({
                        title: 'Atualizado com sucesso!',
                        text: data.message,
                        type: 'success'
                   });
                    console.log(data)
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

    function editarOS(id){
        $.ajax({
            url: `ordens/`+id,
            success: function (data) {
                $("#modalEditar").modal("show");

                var date = new Date(data[0].realized_date);

                $("#modalEditar #id").val(data[0].id);
                $("#modalEditar #problem").val(data[0].problem);
                $("#modalEditar #problem_type").val(data[0].problem_type);
                $("#modalEditar #local").val(data[0].locale);
                $("#modalEditar #workstation").val(data[0].workstation);
                $("#modalEditar #realized_date").val(date.getFullYear()+"-"+("0" + date.getMonth()).slice(-2)+"-"+("0" + date.getDate()).slice(-2));
                $("#modalEditar #designated_employee").val(data[0].solver_employee);
                $("#modalEditar #solver").val(data[0].solver);
                $("#modalEditar #status_id").val(data[0].status_id);
                
            },
            method: "GET"
        });
    }

    function visualizarOS(id){
        $.ajax({
            url: `ordens/`+id,
            success: function (data) {
                console.log(data);
                $("#modalVisualizar").modal("show");
                var date = new Date(data[0].realized_date);

                $("#modalVisualizar #problem").val(data[0].problem);
                $("#modalVisualizar #problem_type").val(data[0].problem_type);
                $("#modalVisualizar #local").val(data[0].locale);
                $("#modalVisualizar #workstation").val(data[0].workstation);
                $("#modalVisualizar #realized_date").val(date.getFullYear()+"-"+("0" + date.getMonth()).slice(-2)+"-"+("0" + date.getDate()).slice(-2));
                $("#modalVisualizar #designated").val(data[0].designated);
                $("#modalVisualizar #solver").val(data[0].solver);
                if(data[0].deleted_at != null){
                    $("#modalVisualizar #status").val("Cancelado");
                }else{
                    $("#modalVisualizar #status").val(data[0].status);
                }

            },
            method: "GET"
        });
    }

    function disable(id){
        Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao cancelar a ordem de serviço, você não poderá reverter isso! Apenas contatando o suporte.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, cancele!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `ordens/`+id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                            Swal.fire({
                                title: 'Cancelado!',
                                text: data.message,
                                type: 'success'
                            });
                        },
                        error:function(data){
                            Swal.fire({
                                title: 'Algo de errado aconteceu!',
                                text: data.responseJSON.message,
                                type: 'error'
                            });
                        }
                    });
                }
           });
    }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
@stop