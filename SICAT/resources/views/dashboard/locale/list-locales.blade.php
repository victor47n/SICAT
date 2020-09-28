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
                    <table id="tLocales" class="table table-hover table-bordered">
                        <thead class="thead-dark">
                        <tr role="row">
                            <th class="sorting">ID</th>
                            <th class="sorting_asc">Local</th>
                            <th>Salas</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel"
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
                    <h5 class="modal-title" id="modalViewLabel">Editar Local</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-bold text-left mb-4">Local</h4>
                    <form id="formView" novalidate="novalidate">
                        <fieldset disabled>
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputNameView">
                            </div>
                            <h4 class="text-bold text-left mb-4 mt-4">Salas</h4>
                            <div id="sala-row-view">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
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
                    <h5 class="modal-title" id="modalEditLabel">Editar Local</h5>
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
                            <input type="text" class="form-control" id="inputNameEdit" name="name">
                        </div>
                        <h3>Salas</h3>
                        <div id="sala-row-edit">

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
        $(document).ready(function () {
            let table = $('#tLocales');
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
                        name: 'name'
                    },
                    {
                        data: 'workstations[,].name',
                        name: 'workstations[,].name',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
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
                        targets: 2,
                        render: function (data) {
                            let dbData = data.split(',')
                            let items = '';
                            let arr = ['primary', 'secondary', 'success', 'danger', 'info', 'dark', 'warning'];
                            for (let i = 0; i < dbData.length; i++) {
                                let idx = Math.floor(Math.random() * arr.length);
                                items += '<span class="badge badge-' + arr[idx] + ' mr-1 ml-1">' + dbData[i] + '</span>'
                            }
                            items += '...';
                            return items;
                        }
                    },
                    {
                        targets: 3,
                        width: "30%",
                        visible: {{Gate::allows('rolesUser', ['workstation_disable', 'workstation_edit', 'workstation_view']) ? 'true' : 'false'}}
                    }
                ],
                drawCallback: function () {
                    $('#tLocales tbody tr td:last-child').addClass('text-center');
                    $('#tLocales_paginate ul.pagination').addClass("justify-content-start");
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
                url: 'locais/' + recipient,
                context: 'json',
                success: function (data) {
                    $("#formEdit").removeClass('d-none');
                    $("#sala-row-edit").html('');
                    $('#inputNameEdit').val(data.name);

                    let workstations = data.workstation;

                    workstations.forEach(element => {
                        let statusButton = "";

                        let status;

                        if (element.deleted_at == null) {
                            status = 'able';
                        } else {
                            status = 'disable';
                        }

                        if (status === 'able') {
                            statusButton = `<button id="delete-${element.id}"  onclick="disableWorkstation(${element.id})" type="button" class="btn btn-danger btn-block"><i class="fas fa-fw fa-trash"></i></button>`
                        } else {
                            statusButton = `<button id="delete-${element.id}" onclick="ableWorkstation(${element.id})" type="button" class="btn btn-primary btn-block"><i class="fas fa-fw fa-trash-restore"></i></button>`
                        }

                        $("#sala-row-edit").append(`
                       <div id="sala-row-${element.id}" class="row">
                            <div class="form-group col-10">
                                    <input type="text" data-status=${status} onfocusout="updateWorkstation(${element.id})" value="${element.name}" class="form-control" id="sala-${element.id}" name="sala[]" placeholder="Nome da sala">
                            </div>
                            <div class="col-xs-12 col-md-2">${statusButton}</div>
                        </div>`);
                    });

                    $("#sala-row-edit").append(`
                        <div  id="sala-row" class="row">
                            <div class="form-group col-10">
                                    <input type="text" class="form-control" id="novasala" name="novasala" placeholder="Nome da sala">
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <button id="insert" onclick="addworkstation(${data.id})" type="button" class="btn btn-info btn-block"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>`);

                    $('#updateButton').attr('onclick', 'update(' + data.id + ')').show();
                    $('#modalEdit').modal('show');
                    loaderObj.hide();

                },
                error: function () {
                    console.log('Ocorreu um erro ao encontrar o funcionário');
                }
            });
        });

        $('#modalView').on('show.bs.modal', function (event) {
            clearModal('formView');
            loaderObj.show();
            let button = $(event.relatedTarget); // Botão que acionou o modal
            let recipient = button.data('whatever'); // Extrai informação dos atributos data-*
            $.ajax({
                type: 'GET',
                url: 'locais/' + recipient,
                context: 'json',
                success: function (data) {
                    $("#formView").removeClass('d-none');
                    $("#sala-row-view").html('');
                    $('#inputNameView').val(data.name);

                    let workstations = data.workstation;

                    workstations.forEach(element => {

                        $("#sala-row-view").append(`
                       <div class="row">
                            <div class="form-group col-12">
                                    <input type="text" data-status=${element.status} value="${element.name}" class="form-control" id="sala-${element.id}">
                            </div>
                        </div>`);


                    });
                    loaderObj.hide();
                },
                error: function () {
                    console.log('Ocorreu um erro ao encontrar o local');
                }
            });
        });

        function update(id) {
            $.ajax({
                type: 'PUT',
                url: `locais/${id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {name: $('#inputNameEdit').val()},
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                    $('#tLocales').DataTable().ajax.reload();
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
                        url: `locais/${id}/desabilitar`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Desabilitado!',
                                text: data.message,
                                type: 'success'
                            });
                            $('#tLocales').DataTable().ajax.reload();
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

        function updateWorkstation(id) {
            $.ajax({
                type: 'PUT',
                url: `postos/${id}`,
                dataType: 'json',
                data: {name: $("#sala-row" + id + " div input").val()},
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

                            $("#sala-" + id + " > div > input").attr("data-status", "disable");
                            $("#delete-" + id).attr('onclick', 'ableWorkstation(' + id + ')')
                                .toggleClass("btn-danger btn-primary")
                                .html(`<i class="fas fa-fw fa-trash-restore"></i>`);

                            $('#tLocales').DataTable().ajax.reload();
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

        function able(id) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Deseja habilitar o local?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, habilite o local!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: `locais/${id}/habilitar`,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Habilitado!',
                                text: data.message,
                                type: 'success'
                            });

                            $("#sala-" + id + " > div > input").attr("data-status", "able");
                            $("#delete-" + id).attr('onclick', 'disableWorkstation(' + id + ')')
                                .toggleClass("btn-primary btn-danger")
                                .html(`<i class="fas fa-fw fa-trash"></i>`)

                            $('#tLocales').DataTable().ajax.reload();
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

                            $("#sala-" + id + " > div > input").attr("data-status", "able");
                            $("#delete-" + id).attr('onclick', 'disableWorkstation(' + id + ')')
                                .toggleClass("btn-primary btn-danger")
                                .html(`<i class="fas fa-fw fa-trash"></i>`)

                            $('#tLocales').DataTable().ajax.reload();
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

        function addworkstation(id) {
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

                    console.log(data);

                    $(`<div id="sala-${data.id}" class="row">
                    <div class="form-group col-10">
                        <input type="text" data-status="able" value="${data.name}" class="form-control" id="sala-${data.id}" name="sala[]" placeholder="Nome da sala">
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <button id="delete-${data.id}" onclick="disableWorkstation(${data.id})" type="button" class="btn btn-danger btn-block"><i class="fas fa-fw fa-trash"></i></button>
                    </div>
                    </div>`).insertBefore("#sala-row");

                    $('#novasala').val('');

                    $('#tLocales').DataTable().ajax.reload();
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
