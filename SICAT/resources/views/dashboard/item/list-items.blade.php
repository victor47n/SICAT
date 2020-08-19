@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Itens</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Itens</li>
    <li class="breadcrumb-item active">Listar</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cadastros de itens</h3>
                </div>
                <div class="card-body">
                    <table id="tItems" class="table table-hover table-borderless">
                        <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting_asc">Nome</th>
                            <th class="sorting">Quantidade</th>
                            <th class="sorting">Disponibilidade</th>
                            <th class="sorting">Tipo</th>
                            <th class="sorting">Opções</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="overlay">
                    <div class="d-flex h-100 justify-content-center align-items-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formEdit" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputNameEdit">Nome</label>
                            <input type="text" class="form-control" id="inputNameEdit" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="inputAmountEdit">Quantidade</label>
                            <input type="text" class="form-control" id="inputAmountEdit" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="inputAvailabilityEdit">Disponibilidade</label>
                            <select id="inputAvailabilityEdit" class="form-control" name="availability" required>
                                <option value="true">Em estoque</option>
                                <option value="false">Sem estoque</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputTypeEdit">Tipo</label>
                            <select id="inputTypeEdit" class="form-control" name="type_id" required>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
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

@section('plugins.Datatables', true)
@section('plugins.Inputmask', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>

        $(document).ready(function () {
            var table = $('#tItems');
            table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                deferRender: true,
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
                    url: '{{ route('item.index') }}',
                },
                rowId: function (a) {
                    return 'row_' + a.id;
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'nome',
                    },
                    {
                        data: 'amount',
                        name: 'quantidade'
                    },
                    {
                        data: 'availability',
                        name: 'disponibilidade'
                    },
                    {
                        data: 'type',
                        name: 'tipo'
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
                    },
                    {
                        targets: 3,
                        render: function (data) {
                            if (data == 'true') {
                                return '<span class="badge badge-success">Em estoque</span>';
                            }
                            if (data == 'false') {
                                return '<span class="badge badge-danger">Sem estoque</span>';
                            }
                        }
                    },
                    {
                        targets: 5,
                        visible: {{Gate::allows('rolesUser', ['item_disable', 'item_edit', 'item_view']) ? 'true' : 'false'}},
                        width: "20%"
                    },
                ],
                drawCallback: function () {
                    $('#tItems tbody tr td:last-child').addClass('text-center');
                    $('#tItems_paginate ul.pagination').addClass("justify-content-start");
                }
            });

        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function clearModal(formModal) {
            $("#" + formModal).addClass('d-none');
            $("#" + formModal)[0].reset();
        }

        function loader() {
            this.id = '.overlay'
        };

        loader.prototype.show = function () {
            $(this.id).fadeIn();
        };

        loader.prototype.hide = function () {
            $(this.id).fadeOut('slow', function () {
                $(this.id).attr("style", "display: none !important");
            });
        };

        loaderObj = new loader();

        $('#modalEdit').on('show.bs.modal', function (event) {
            clearModal('formEdit');
            loaderObj.show();
            let button = $(event.relatedTarget); // Botão que acionou o modal
            let recipient = button.data('whatever'); // Extrai informação dos atributos data-*
            $.ajax({
                type: 'GET',
                url: 'itens/' + recipient,
                context: 'json',
                success: function (data) {
                    $("#formEdit").removeClass('d-none');

                    data.map(_data => {
                        $('#inputNameEdit').val(_data.name);
                        $('#inputAmountEdit').val(_data.amount);

                        let opt;

                        for (let i = 0, len = $('#inputAvailabilityEdit option').length; i < len; i++) {
                            opt = $('#inputAvailabilityEdit option')[i];
                            if (opt.value == _data.availability) {
                                opt.setAttribute('selected', true);
                            }
                        }

                        for (let i = 0, len = $('#inputTypeEdit option').length; i < len; i++) {
                            opt = $('#inputTypeEdit option')[i];
                            if (opt.text == _data.type) {
                                opt.setAttribute('selected', true);
                            }
                        }
                        $('#updateButton').attr('onclick', 'update(' + recipient + ')');
                    });

                    loaderObj.hide();
                },
                error: function () {
                    console.log('Ocorreu um erro ao encontrar o funcionário');
                }
            });
        });

        function update(id) {
            $.ajax({
                type: 'PUT',
                url: 'itens/' + id,
                dataType: 'json',
                data: $('#formEdit').serialize(),
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                    $('#tItems').DataTable().ajax.reload();
                },
                error: function (data) {
                    Toast.fire({
                        type: 'error',
                        title: data.responseJSON.message
                    });

                }
            });
        };

        function disable(id) {
            let table = $('#tItems').DataTable();
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao desabilitar o item, você não poderá reverter isso! Apenas contatando o suporte.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desabilite o item!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: 'itens/' + id + '/desabilitar',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            table.row('#' + id).remove().draw(false);
                            $('#tItems').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Desabilitado!',
                                text: data.message,
                                type: 'success'
                            });
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
        };
    </script>
@stop
