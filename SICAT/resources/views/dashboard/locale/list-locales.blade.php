@extends('adminlte::page')

@section('title', 'Postos de Trabalhos')

@section('content_header')
<h1>Postos de trabalho</h1>
@stop

@section('breadcrumb')
<li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
<li class="breadcrumb-item active">Postos de trabalho</li>
<li class="breadcrumb-item active">Listar</li>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cadastros de Postos de trabalho</h3>
            </div>
            <div class="card-body">
                <table id="tLocais" class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting_asc">Nome</th>
                            <th class="sorting">Opções</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Local</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="formEdit" novalidate="novalidate">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group">
                        <label for="inputName">Nome</label>
                        <input type="text" class="form-control" id="inputName" name="name">
                    </div>
                    <div id="sala-row" class="form-row">

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
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

    $(document).ready(function () {
            var table = $('#tLocais');
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
                    url: '{{ route('locale.index') }}',
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'nome'
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
                    $('#tUsers tbody tr td:eq(2)',).addClass('text-center');
                    $('#tUsers_paginate ul.pagination').addClass("justify-content-start");
                }
            });
        });


        function showEditModal(id) {
            $.ajax({
                type: 'GET',
                url: `show/${id}`,
                context: 'json',
                success: function (data) {
                    $("#sala-row").html('');
                    $('#inputName').val(data.name);
                    workstations = data.workstation;

                    workstations.forEach(element => {
                        statusButton ="";
                       if(element.status == 'able'){
                            statusButton = `<button id="delete-${element.id}"  onclick="disableWorkstation(${element.id})" type="button" class="btn btn-success"><i class="fas fa-check"></i></button>`
                        }else{
                            statusButton = `<button id="delete-${element.id}" onclick="ableWorkstation(${element.id})" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>`

                        }

                       $("#sala-row").append(`
                       <div  id="sala-${element.id}"  class="col-12 row">
                            <div class="form-group col-10">
                                    <input type="text" data-status=${element.status} onfocusout="updateWorkstation(${element.id})" value=${element.name} class="form-control" id="sala[]" name="sala[]" placeholder="Nome da sala">
                            </div>
                            <div class="col-auto">${statusButton}</div>
                        </div>`);


                    });

                    $("#sala-row").append(`
                        <div  id="sala"  class="col-12 row">
                            <div class="form-group col-10">
                                    <input type="text" class="form-control" id="novasala" name="novasala"  placeholder="Nome da sala">
                            </div>
                            <div class="col-auto">
                                <button id="insert" onclick="addworkstation(${data.id})" type="button" class="btn btn-info"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>`);
                    $('#inputEmail').val(data.email);
                    $('#updateButton').attr('onclick', 'update(' + data.id + ')');
                    $('#modalEdit').modal('show');
                },
                error: function () {
                    console.log('Ocorreu um erro ao encontrar o funcionário');
                }
            });
        }

        function update(id) {
            $.ajax({
                type: 'PUT',
                url: `update/${id}`,
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                dataType: 'json',
                data: {name: $('#inputName').val()},
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                    $('#tLocais').DataTable().ajax.reload();
                },
                error: function (data) {
                    Toast.fire({
                        type: 'error',
                        title: data.responseJSON.message
                    });

                }
            });
        }

        function disable(id) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao desabilitar o local de trabalho.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desabilite o local de trabalho!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: `disable/${id}`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Desabilitado!',
                                text: data.message,
                                type: 'success'
                            });
                            $('#tLocais').DataTable().ajax.reload();
                        },
                        error: function (data) {
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

        function updateWorkstation(id){
            $.ajax({
                type: 'PUT',
                url: `postos/${id}/update`,
                dataType: 'json',
                data: {name: $("#sala-"+id+" div input").val()},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        }

        function disableWorkstation(id) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao desabilitar o local de trabalho.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desabilite o local de trabalho!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: `postos/${id}/desabilitar`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Desabilitado!',
                                text: data.message,
                                type: 'success'
                            });

                            $("#sala-"+id+" > div > input").attr("data-status", "disable");
                            $("#delete-"+id).attr('onclick', 'ableWorkstation(' + id + ')')
                                .toggleClass("btn-success btn-danger")
                                .html(`<i class="fas fa-times"></i>`);

                           // $('#tLocais').DataTable().ajax.reload();
                        },
                        error: function (data) {
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

        function ableWorkstation(id) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Deseja habilitar o local de trabalho?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, habilite o local de trabalho!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: `postos/${id}/habilitar`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Habilitado!',
                                text: data.message,
                                type: 'success'
                            });

                            $("#sala-"+id+" > div > input").attr("data-status", "able");
                            $("#delete-"+id).attr('onclick', 'disableWorkstation(' + id + ')')
                                .toggleClass("btn-success btn-danger")
                                .html(`<i class="fas fa-check"></i>`)

                        // $('#tLocais').DataTable().ajax.reload();
                        },
                        error: function (data) {
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

        function addworkstation(id){
            $.ajax({
                type: 'POST',
                url: "{{ route('workstation.store') }}",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    id: id,
                    name: $('#novasala').val()
                },
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });

                    data = data.data;
                    $(`<div id="sala-${data.id}" class="col-12 row">
                    <div class="form-group col-10">
                        <input type="text" data-status="" value=${data.name} class="form-control" id="sala[]" name="sala[]" placeholder="Nome da sala">
                    </div>
                    <div class="col-auto">
                        <button id="delete-${data.id}" onclick="disableWorkstation(${data.id})" type="button" class="btn btn-success"><i class="fas fa-check"></i></button>
                    </div>
                    </div>`).insertBefore("#sala");

                    $('#tLocais').DataTable().ajax.reload();
                },
                error: function (data) {
                    Toast.fire({
                        type: 'error',
                        title: data.responseJSON.message
                    });

                }
            });
        }
</script>
@stop
