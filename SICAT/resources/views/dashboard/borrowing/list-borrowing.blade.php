@extends('adminlte::page')

@section('title', 'Funcionários')

@section('content_header')
    <h1>Empréstimos</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Empréstimos</li>
    <li class="breadcrumb-item active">Listar</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Empréstimos realizados</h3>
                </div>
                <div class="card-body">
                    <table id="tBorrowings" class="table table-hover table-borderless">
                        <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting_asc">Nome do requisitante</th>
                            <th class="sorting_asc">Email</th>
                            <th class="sorting">Itens</th>
                            <th class="sorting">Data de aquisição</th>
                            <th class="sorting">Status</th>
                            <th class="sorting">Opções</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
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
                    <h5 class="modal-title" id="viewModalLabel">Dados do funcionário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formView" class="d-none">
                        <fieldset disabled>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="inputNameView">Nome do requisitante</label>
                                    <input type="text" class="form-control-plaintext" id="inputNameView">
                                </div>
                                <div class="form-group col-8">
                                    <label for="inputEmailView">Email</label>
                                    <input type="email" class="form-control-plaintext" id="inputEmailView">
                                </div>
                                <div class="form-group col-4">
                                    <label for="inputPhoneView">Telefone</label>
                                    <input type="text" class="form-control-plaintext" id="inputPhoneView">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputOfficeView">Cargo</label>
                                    <input type="text" class="form-control-plaintext" id="inputOfficeView">
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputDateView">Data de aquisição</label>
                                    <input type="text" class="form-control-plaintext" id="inputDateView">
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputStatusView">Status</label>
                                    <input type="text" class="form-control-plaintext" id="inputStatusView">
                                </div>
                            </div>
                            <h4 class="text-bold text-left mb-4 mt-4">Itens emprestados</h4>
                            <div id="fItems">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="overlay">
                    <div class="d-flex h-100 justify-content-center align-items-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar empréstimo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formEdit">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="inputNameEdit">Nome do requisitante</label>
                                <input type="text" class="form-control" id="inputNameEdit" name="requester"
                                       placeholder="Nome" required readonly>
                            </div>
                            <div class="form-group col-8">
                                <label for="inputEmailEdit">Email</label>
                                <input type="email" class="form-control" id="inputEmailEdit" name="email_requester"
                                       placeholder="exemplo@abc.xyz" required readonly>
                            </div>
                            <div class="form-group col-4">
                                <label for="inputPhoneEdit">Telefone</label>
                                <input type="text" class="form-control" id="inputPhoneEdit" name="phone_requester"
                                       placeholder="(99) 99999-9999" required readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputOfficeEdit">Cargo</label>
                                <input type="text" class="form-control" id="inputOfficeEdit" name="office_requester" readonly>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputDateEdit">Data de aquisição</label>
                                <input type="text" class="form-control" id="inputDateEdit" name="acquisition_date"
                                       placeholder="dd/mm/aaaa" required readonly>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputStatusEdit">Status</label>
                                <input type="text" class="form-control" id="inputStatusEdit" name="status" required readonly>
                            </div>
                        </div>
                        <h4 class="text-bold text-left mb-3 mt-4">Itens emprestados</h4>
                        <div id="fItemsEdit">
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

@section('plugins.Validation', true)
@section('plugins.Inputmask', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>

        $(document).ready(function () {
            var table = $('#tBorrowings');
            table.DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: {
                    details: true,
                    type: 'column'
                },
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
                    url: '{{ route('borrowing.index') }}',
                },
                rowId: function(a) {
                    return 'row_' + a.id;
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'requester',
                        name: 'nome',
                    },
                    {
                        data: 'email_requester',
                        name: 'email'
                    },
                    {
                        data: 'items[,].name',
                        name: 'itens'
                    },
                    {
                        data: 'acquisition_date',
                        name: 'data de aquisição'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                            let dbData = data.split(',')
                            let items = '';
                            let arr = ['primary', 'secondary', 'success', 'danger', 'info', 'dark'];
                            for (let i = 0; i < dbData.length; i++) {
                                let idx = Math.floor(Math.random() * arr.length);
                                items += '<span class="badge badge-'+arr[idx]+' mr-1 ml-1">'+dbData[i]+'</span>'
                            }
                            return items;
                        }
                    },
                    {
                        targets: 6,
                        visible: {{Gate::allows('rolesUser', ['borrowing_disable', 'borrowing_edit', 'borrowing_view']) ? 'true' : 'false'}}
                    }
                ],
                drawCallback: function () {
                    $('#tBorrowings tbody tr td:last-child').addClass('text-center');
                    $('#tBorrowings_paginate ul.pagination').addClass("justify-content-start");
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
            $("#" +formModal).addClass('d-none');
            $("#" +formModal)[0].reset();
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

        $('#modalView').on('show.bs.modal', function (event) {
            clearModal('formView');
            loaderObj.show();
            let button = $(event.relatedTarget); // Botão que acionou o modal
            let recipient = button.data('whatever'); // Extrai informação dos atributos data-*

            $.ajax({
                type: 'GET',
                url: 'funcionarios/' + recipient,
                context: 'json',
                success: function (data) {

                    $("#formView").removeClass('d-none');

                    data.map(_data => {
                        $('#inputNameView').val(_data.name);
                        $('#inputEmailView').val(_data.email);
                        $('#inputPhoneView').val(_data.phone);
                        $('#inputOfficeView').val(_data.office);
                        $('#inputPermissionView').val(_data.permission);
                    });
                    loaderObj.hide();
                },
            });
        })

        $('#modalEdit').on('show.bs.modal', function (event) {
            clearModal('formEdit');
            loaderObj.show();
            let button = $(event.relatedTarget); // Botão que acionou o modal
            let recipient = button.data('whatever'); // Extrai informação dos atributos data-*
            $.ajax({
                type: 'GET',
                url: 'emprestimos/' + recipient,
                context: 'json',
                success: function (data) {
                    $("#formEdit").removeClass('d-none');
                    $('#fItemsEdit').html('');
                    data.map(_data => {
                        $('#inputNameEdit').val(_data.requester);
                        $('#inputEmailEdit').val(_data.email_requester);
                        $('#inputPhoneEdit').val(_data.phone_requester);
                        $('#inputOfficeEdit').val(_data.office_requester);
                        $('#inputDateEdit').val(_data.acquisition_date);
                        $('#inputStatusEdit').val(_data.status);

                        let count = 0;

                        _data.items.map(_items => {
                            let tItems = '<div id="row-'+count+'" class="form-row mt-1 mb-2">' +
                                '<input type="hidden" id="inputId-'+count+'" name="id" value="'+_items.id+'">' +
                                '<div class="form-group col-md-12 col-lg-3">' +
                                    '<label for="inputItem-'+count+'">Item</label>' +
                                    '<input type="text" class="form-control" id="inputItem-'+count+'" value="'+_items.name+'" readonly>' +
                                '</div>' +
                                    '<div class="form-group col-md-12 col-lg-2">' +
                                    '<label for="inputAmount-'+count+'">Quantidade</label>' +
                                    '<input type="text" class="form-control" id="inputAmount-'+count+'" value="'+_items.amount+'" readonly>' +
                                '</div>' +
                                '<div class="form-group col-md-12 col-lg-2">' +
                                    '<label for="inputAmountF-'+count+'">Quantidade a devolver</label>' +
                                    '<input type="text" class="form-control" id="inputAmountF-'+count+'" data-inputmask="\'alias\': \'numeric\', \'allowMinus\': \'true\', \'allowPlus\': \'true\', \'min\': \'0\', \'max\': \''+_items.amount+'\', \'digits\': \'0\'">' +
                                '</div>' +
                                '<div class="form-group col-md-12 col-lg-3">' +
                                    '<label for="inputDate-'+count+'">Data de devolução</label>' +
                                    '<input type="date" class="form-control" id="inputDate-'+count+'" name="acquisition_date"' +
                                    'placeholder="dd/mm/aaaa" required>' +
                                '</div>' +
                                '<div class="custom-control custom-checkbox align-items-center justify-content-center d-flex col-md-12 col-lg-2">' +
                                    ' <input type="checkbox" class="custom-control-input" id="checkDevolution-'+count+'">' +
                                    '<label class="custom-control-label" for="checkDevolution-'+count+'">Devolver</label>' +
                                '</div>' +
                                '</div>';
                            $('#fItemsEdit').append(tItems);

                            count++
                        });


                        $('#updateButton').attr('onclick', 'update(' + recipient + ')');
                    });
                    $(":input").inputmask();
                    loaderObj.hide();
                },
                error: function () {
                    console.log('Ocorreu um erro ao encontrar o funcionário');
                }
            });
        });

        function update(id) {
            let line_items = $("#fItemsEdit > .form-row").not(":hidden").length;

            let data = {};

            for (let i = 0; i < line_items; i++){
                if($('#checkDevolution-'+i).is(":checked"))
                {
                    data[i] = {
                        id: $('#inputId-'+i).val(),
                        amount: $('#inputAmountF-'+i).val(),
                        return_date: $('#inputDate-'+i).val(),
                    }
                }
            }

            $.ajax({
                type: 'PUT',
                url: 'emprestimos/' + id,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                    $('#tUsers').DataTable().ajax.reload();
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
            let table = $('#tUsers').DataTable();
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao desabilitar o funcionário, você não poderá reverter isso! Apenas contatando o suporte.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desabilite o funcionário!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: 'funcionarios/' + id + '/desabilitar',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            table.row('#' +id).remove().draw(false);
                            $('#tUsers').DataTable().ajax.reload();
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
        }
    </script>
@stop

