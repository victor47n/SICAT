@extends('adminlte::page')

@section('title', 'Funcionários')

@section('content_header')
    <h1>Funcionários</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
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
                    <table id="tUsers" class="table table-hover table-borderless">
                        <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting_asc">Nome</th>
                            <th class="sorting">Email</th>
                            <th class="sorting">Telefone</th>
                            <th class="sorting">Cargo</th>
                            <th class="sorting">Permissão</th>
                            <th class="sorting">Opções</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="modal fade" id="modalLoader" tabindex="1" role="dialog" aria-labelledby="viewModalLabel"--}}
    {{--         aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-dialog-centered" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="overlay d-flex justify-content-center align-items-center">--}}
    {{--                    <div class="spinner-border" role="status">--}}
    {{--                        <span class="sr-only">Loading...</span>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

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
                            <div class="form-group">
                                <label for="inputNameView">Nome</label>
                                <input type="text" class="form-control-plaintext" id="inputNameView">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmailView">Email</label>
                                    <input type="text" class="form-control-plaintext" id="inputEmailView">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPhoneView">Telefone</label>
                                    <input type="text" class="form-control-plaintext" id="inputPhoneView">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputOfficeView">Cargo</label>
                                    <input type="text" class="form-control-plaintext" id="inputOfficeView">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPermissionView">Permissão</label>
                                    <input type="text" class="form-control-plaintext" id="inputPermissionView">
                                </div>
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
                            <label for="inputEmailEdit">Email</label>
                            <input type="text" class="form-control" id="inputEmailEdit" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="inputPhoneEdit">Telefone</label>
                            <input type="text" class="form-control" id="inputPhoneEdit" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="inputOfficeEdit">Cargo</label>
                            <select id="inputOfficeEdit" class="form-control" name="office" required>
                                <option>Funcionário</option>
                                <option>Estagiário</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputPermissionEdit">Permissão</label>
                            <select id="inputPermissionEdit" class="form-control" name="role_id" required>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
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

@section('css')
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Validation', true)

@section('js')
    <script>

        $(document).ready(function () {
            var table = $('#tUsers');
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
                    url: '{{ route('user.index') }}',
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
                        data: 'name',
                        name: 'nome',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'telefone'
                    },
                    {
                        data: 'office',
                        name: 'cargo'
                    },
                    {
                        data: 'permission',
                        name: 'permissão'
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
                        targets: 6,
                        visible: {{Gate::allows('rolesUser', ['employee_disable', 'employee_edit', 'employee_view']) ? 'true' : 'false'}}
                    }
                ],
                drawCallback: function () {
                    $('#tUsers tbody tr td:last-child').addClass('text-center');
                    $('#tUsers_paginate ul.pagination').addClass("justify-content-start");
                }
            });

            $('#formEdit').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                },
                messages: {
                    name: {
                        required: "Digite um nome",
                    },
                    email: {
                        required: "Digite um endereço de email",
                        email: "Por favor insira um email válido."
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
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
                url: 'funcionarios/' + recipient,
                context: 'json',
                success: function (data) {
                    $("#formEdit").removeClass('d-none');

                    data.map(_data => {
                        $('#inputNameEdit').val(_data.name);
                        $('#inputEmailEdit').val(_data.email);
                        $('#inputPhoneEdit').val(_data.phone);

                        let opt;

                        for (let i = 0, len = $('#inputOfficeEdit option').length; i < len; i++) {
                            opt = $('#inputOfficeEdit option')[i];
                            if (opt.text == _data.office) {
                                opt.setAttribute('selected', true);
                            }
                        }

                        for (let i = 0, len = $('#inputPermissionEdit option').length; i < len; i++) {
                            opt = $('#inputPermissionEdit option')[i];
                            if (opt.text == _data.permission) {
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
                url: 'funcionarios/' + id,
                dataType: 'json',
                data: $('#formEdit').serialize(),
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
        };

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
        };
    </script>
@stop

