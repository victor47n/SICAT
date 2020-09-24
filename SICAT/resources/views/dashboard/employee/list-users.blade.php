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
                            @if(Gate::allows('rolesUser', ['employee_restore']))
                                <th class="sorting">Status</th>
                            @endif
                            <th>Opções</th>
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
            $('#formEdit').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    office: {
                        required: true,
                    },
                    role_id: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "O campo nome é obrigatório.",
                    },
                    email: {
                        required: "O campo email é obrigatório.",
                        email: "Por favor, insira um e-mail válido."
                    },
                    office: {
                        required: "O cargo é obrigatório."
                    },
                    role_id: {
                        required: "O nivel de permissão é obrigatório."
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
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-fw fa-file-excel"></i>Excel',
                        titleAttr: 'Exportar Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-fw fa-file-pdf"></i>PDF',
                        titleAttr: 'Exportar PDF',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        },
                        customize: function (doc) {
                            //Remove the title created by datatTables
                            doc.content.splice(0, 1);
                            //Create a date string that we use in the footer. Format is dd-mm-yyyy
                            var now = new Date();
                            var jsDate = now.toLocaleDateString();
                            // Logo converted to base64
                            // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
                            // The above call should work, but not when called from codepen.io
                            // So we use a online converter and paste the string in.
                            // Done on http://codebeautify.org/image-to-base64-converter
                            // It's a LONG string scroll down to see the rest of the code !!!
                            var logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABBwAAAQcCAYAAAA2m4gFAAABJmlDQ1BBZG9iZSBSR0IgKDE5OTgpAAAoz2NgYDJwdHFyZRJgYMjNKykKcndSiIiMUmA/z8DGwMwABonJxQWOAQE+IHZefl4qAwb4do2BEURf1gWZxUAa4EouKCoB0n+A2CgltTiZgYHRAMjOLi8pAIozzgGyRZKywewNIHZRSJAzkH0EyOZLh7CvgNhJEPYTELsI6Akg+wtIfTqYzcQBNgfClgGxS1IrQPYyOOcXVBZlpmeUKBhaWloqOKbkJ6UqBFcWl6TmFit45iXnFxXkFyWWpKYA1ULcBwaCEIWgENMAarTQZKAyAMUDhPU5EBy+jGJnEGIIkFxaVAZlMjIZE+YjzJgjwcDgv5SBgeUPQsykl4FhgQ4DA/9UhJiaIQODgD4Dw745AMDGT/0ZOjZcAAAACXBIWXMAABcSAAAXEgFnn9JSAAAK82lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDggNzkuMTY0MDM2LCAyMDE5LzA4LzEzLTAxOjA2OjU3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgSWxsdXN0cmF0b3IgQ0MgMjAxNSAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDE2LTA5LTIzVDE2OjMyOjQ3KzAyOjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMC0wNy0wMVQyMDowMDo1MC0wMzowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMC0wNy0wMVQyMDowMDo1MC0wMzowMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDowNWRiOGFmYi05YzE5LTk4NDItYjZiOS0yZTNjMDBmZTA4ZTIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MmM0YjIzMGItYjk0NC01ZTQ2LTk2NzUtMDBhNjI3ODI3MWM0IiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6ZTM5YTk4YmEtOTQ3ZC05ODQwLWI5MTMtMjMyNjk5ZjhiNmU4IiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3gtcGhvdG9zaG9wIHRvIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmUzOWE5OGJhLTk0N2QtOTg0MC1iOTEzLTIzMjY5OWY4YjZlOCIgc3RFdnQ6d2hlbj0iMjAxNi0wOS0yM1QxNjozMjo0NyswMjowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgSWxsdXN0cmF0b3IgQ0MgMjAxNSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBhcHBsaWNhdGlvbi94LXBob3Rvc2hvcCB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1OGY5NzMzMC03NzFhLWQ2NDYtYWI5ZC1mOTEzYmM5YTFmODUiIHN0RXZ0OndoZW49IjIwMTYtMDktMjNUMTY6MzI6NDcrMDI6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIElsbHVzdHJhdG9yIENDIDIwMTUgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MjBkNzg5NS02OTA2LTMxNDQtYThlNy04NmMzMjhhOTc0NmIiIHN0RXZ0OndoZW49IjIwMjAtMDctMDFUMjA6MDA6NTAtMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MmM0YjIzMGItYjk0NC01ZTQ2LTk2NzUtMDBhNjI3ODI3MWM0IiBzdEV2dDp3aGVuPSIyMDIwLTA3LTAxVDIwOjAwOjUwLTAzOjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoV2luZG93cykiIHN0RXZ0OmNo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';
                            // A documentation reference can be found at
                            // https://github.com/bpampuch/pdfmake#getting-started
                            // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                            // or one number for equal spread
                            // It's important to create enough space at the top for a header !!!
                            doc.pageMargins = [30, 80, 30, 30];
                            // Set the font size fot the entire document
                            doc.defaultStyle.fontSize = 12;
                            // Set the fontsize for the table header
                            doc.styles.tableHeader.fontSize = 12;
                            doc.styles.tableHeader.fillColor = '#212529';
                            doc.styles.tableHeader.alignment = 'left';
                            // Create a header object with 3 columns
                            // Left side: Logo
                            // Middle: brandname
                            // Right side: A document title
                            doc['header'] = (function () {
                                return {
                                    columns: [
                                        {
                                            image: logo,
                                            width: 36
                                        },
                                        {
                                            alignment: 'center',
                                            italics: false,
                                            text: 'Funcionários',
                                            fontSize: 18,
                                            margin: [0, 10]
                                        },
                                    ],
                                    margin: 20
                                }
                            });
                            // Create a footer object with 2 columns
                            // Left side: report creation date
                            // Right side: current page and total pages
                            doc['footer'] = (function (page, pages) {
                                return {
                                    columns: [
                                        {
                                            alignment: 'left',
                                            text: ['Criado em: ', {text: jsDate.toString()}],
                                            fontSize: 10,
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['Página ', {text: page.toString()}, ' de ', {text: pages.toString()}],
                                            fontSize: 10,

                                        }
                                    ],
                                    margin: [20, 0]
                                }
                            });
                            // Change dataTable layout (Table styling)
                            // To use predefined layouts uncomment the line below and comment the custom lines below
                            // doc.content[0].layout = 'noBorders'; // noBorders , headerLineOnly
                            var objLayout = {};
                            objLayout['hLineWidth'] = function (i) {
                                return 0;
                            };
                            objLayout['vLineWidth'] = function (i) {
                                return 0;
                            };
                            objLayout['paddingLeft'] = function (i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function (i) {
                                return 8;
                            };
                            doc.content[0].layout = objLayout;
                        }
                    },
                ],
                dom: 'B<"row mt-3" <"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row mt-3" <"col-sm-12 col-md-5" i><"col-sm-12 col-md-7" p>>',
                ajax: {
                    url: '{{ route('user.index') }}',
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
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'office',
                        name: 'office'
                    },
                    {
                        data: 'permission',
                        name: 'permission'
                    },
                        @if(Gate::allows('rolesUser', ['employee_restore']))
                    {
                        data: 'deleted_at',
                        name: 'deleted_at'
                    },
                        @endif
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
                        @if(Gate::allows('rolesUser', ['employee_restore']))
                    {
                        targets: 6,
                        visible: {{Gate::allows('rolesUser', ['employee_restore']) ? 'true' : 'false'}},
                        render: function (data) {
                            if (data === null) {
                                return '<span class="badge badge-success">Habilitado</span>';
                            }
                            if (data !== null) {
                                return '<span class="badge badge-danger">Desabilitado</span>';
                            }
                        }
                    },
                        @endif
                    {
                        targets: {{Gate::allows('rolesUser', ['employee_restore']) ? '7' : '6'}},
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
                    $('#modalEdit').modal('hide')
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
                            table.row('#' + id).remove().draw(false);
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

        function restore(id) {
            let table = $('#tUsers').DataTable();
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Ao habilitar o funcionário, ele poderá utilizar as funções de sua função.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, habilite o funcionário!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: 'funcionarios/' + id + '/habilitar',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $('#tUsers').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Habilitado!',
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

