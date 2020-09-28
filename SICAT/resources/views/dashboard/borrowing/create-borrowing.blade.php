@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Empréstimos</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Empréstimo</li>
    <li class="breadcrumb-item active">Realizar</li>
@stop

@section('content')
    <div class="row  justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Realizar empréstimo</h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{dd($errors, $erros->any(), $errors->all())}}
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$erros}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="bForm" novalidate>
                    {{ csrf_field() }}

                    <div class="card-body">
                        <h4 class="text-bold text-left mb-4">Informações do empréstimo</h4>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="inputName">Nome do requisitante</label>
                                <input type="text" class="form-control" id="inputName" name="requester"
                                       placeholder="Nome" autofocus autocomplete="off" required>
                            </div>
                            <div class="form-group col-8">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email_requester"
                                       placeholder="exemplo@abc.xyz" autocomplete="off" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="inputPhone">Telefone</label>
                                <input type="text" class="form-control" id="inputPhone" name="phone_requester"
                                       placeholder="(99) 99999-9999" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputOffice">Cargo</label>
                                <select id="inputOffice" class="form-control custom-select"
                                        name="office_requester"
                                        required>
                                    <option selected disabled value hidden>Escolher...</option>
                                    <option value="Aluno">Aluno</option>
                                    <option value="Coordenador">Coordenador</option>
                                    <option value="Funcionário">Funcionário</option>
                                    <option value="Professor">Professor</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputDate">Data de aquisição</label>
                                <input type="date" class="form-control" id="inputDate" name="acquisition_date"
                                       placeholder="dd/mm/aaaa" required min="{{ date("Y-m-d") }}" value="{{ date("Y-m-d") }}">
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" class="form-control custom-select" name="status_id"
                                        required disabled>
                                    <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="text-bold text-left mb-4 mt-4">Itens para o empréstimo</h4>
                        <div id="fItems" name="items">
                            <div class="form-row align-items-end" id="item-row-0">
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputType">Tipo</label>
                                    <select id="inputType" class="form-control custom-select">
                                        <option selected disabled value hidden>Escolher...</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputItem">Item</label>
                                    <select id="inputItem" class="form-control custom-select" name="item_id">
                                        <option selected disabled value hidden>Escolher...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputAmount">Quantidade</label>
                                    <input type="text" class="form-control" id="inputAmount" name="amount"
                                           placeholder="0" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button id="addItem" type="button" class="btn btn-info">Adicionar itens</button>
                        <button type="submit" class="btn btn-primary">Emprestar</button>
                    </div>
                </form>
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
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(document).ready(function () {

            $('#inputPhone').inputmask('(99) 9999[9]-9999', {showMaskOnFocus: false, showMaskOnHover: false, removeMaskOnSubmit: true, autoUnmask: true});
            $('#inputAmount').inputmask({
                alias: 'numeric',
                allowMinus: true,
                allowPlus: true,
                min: 1,
                max: 100,
                digits: 0,
                showMaskOnFocus: false,
                showMaskOnHover: false,
            });

            var count = 0;

            $('#bForm').validate({
                rules: {
                    requester: {
                        required: true,
                    },
                    email_requester: {
                        required: true,
                        email: true,
                    },
                    office_requester: {
                        required: true,
                    },
                    acquisition_date: {
                        required: true,
                    },
                    status_id: {
                        required: true,
                    },
                },
                messages: {
                    requester: {
                        required: "O campo nome do requisitante é obrigatório.",
                    },
                    email_requester: {
                        required: "O campo email é obrigatório.",
                        email: "Por favor, insira um e-mail válido."
                    },
                    office_requester: {
                        required: "O campo cargo é obrigatório.",
                    },
                    acquisition_date: {
                        required: "O campo data de aquisição é obrigatório."
                    },
                    status_id: {
                        required: "O campo status é obrigatório."
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

            $(document).on('click', '.delete', function () {
                let delete_row = $(this).data('row');

                if ($('#tItems > tbody > tr').length === 1) {
                    $('#tItems').remove();
                    return;
                }

                $('#' + delete_row).remove();
            });

            $("#addItem").on('click', function () {

                let items = {
                    type_id: $('#inputType')
                        .children("option:selected")
                        .val(),
                    type_name: $('#inputType')
                        .children("option:selected")
                        .text(),
                    item_id: $('#inputItem')
                        .children("option:selected")
                        .val(),
                    item_name: $('#inputItem')
                        .children("option:selected")
                        .text(),
                    amount: $('#inputAmount').val(),
                }

                for (let value of Object.values(items)) {
                    if (value === "" || value === 'Escolher...') {
                        return;
                    }
                }

                if ($('#tItems').length === 0) {
                    let tItems = '<table id="tItems" class="table table-sm table-borderless">' +
                        '<thead class="thead-dark">' +
                        '<tr role="row">' +
                        '<th scope="col">Tipo</th>' +
                        '<th scope="col">Item</th>' +
                        '<th scope="col">Quantidade</th>' +
                        '<th scope="col">Excluir</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '</tbody>' +
                        '</table>';

                    $('#fItems').append(tItems);
                } else {
                    count = count + 1;
                }

                $('#tItems tbody:last-child').append(
                    '<tr role="row" id="row-' + count + '">' +
                    '<td id="' + items.type_id + '">' + items.type_name + '</td>' +
                    '<td id="' + items.item_id + '">' + items.item_name + '</td>' +
                    '<td>' + items.amount + '</td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-danger btn-sm delete" data-row="row-' + count + '">' +
                    '<i class="fas fa-fw fa-minus"></i>' +
                    '</button>' +
                    '</td>' +
                    '</tr>'
                );

                $('#inputType').children('option:first').prop('selected', true);
                $('#inputItem').children('option:not(:first)').remove();
                $('#inputItem').children('option:first').prop('selected', true);
                $('#inputAmount').val('');

            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $("#bForm").on("submit", function (e) {
            e.preventDefault();
            if ($('#fItems').hasClass('is-invalid')) {
                $('#fItems').removeClass('is-invalid');
                $('#alert-items').remove();
            }

            let items = [];
            let data = null;
            let requester = $('#inputName').val();
            let phone_requester = $('#inputPhone').val();
            let email_requester = $('#inputEmail').val();
            let office_requester = $('#inputOffice').val();
            let acquisition_date = $('#inputDate').val();
            let status_id = $('#inputStatus').val();

            if ($('#tItems').length === 0) {
                let item = {
                    'item_id': $('#inputItem').val(),
                    'amount': $('#inputAmount').val(),
                };
                if (item.item_id !== null || item.amount !== "") {
                    items.push(item);
                }

                data = {
                    requester: requester,
                    phone_requester: phone_requester,
                    email_requester: email_requester,
                    office_requester: office_requester,
                    acquisition_date: acquisition_date,
                    status_id: status_id,
                    items: items,
                }
            } else {
                $('#tItems tbody tr').each(function (row, tr) {
                    let item = {
                        'item_id': $(tr).find('td:eq(1)').attr('id'),
                        'amount': $(tr).find('td:eq(2)').text(),
                    };

                    if (item.item_id !== null || item.amount !== null) {
                        items.push(item);
                    }
                });

                data = {
                    requester: requester,
                    phone_requester: phone_requester,
                    email_requester: email_requester,
                    office_requester: office_requester,
                    acquisition_date: acquisition_date,
                    status_id: status_id,
                    items: items
                }
            }

            $.ajax({
                url: "{{ route('borrowing.store') }}",
                method: "POST",
                dataType: 'json',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#inputName').val('');
                    $('#inputPhone').val('');
                    $('#inputEmail').val('');
                    $('#inputOffice').children('option:first').prop('selected', true);
                    $('#inputDate').val('');
                    $('#inputStatus').children('option:first').prop('selected', true);
                    $('#inputType').children('option:first').prop('selected', true);
                    $('#inputItem').children('option:not(:first)').remove();
                    $('#inputItem').children('option:first').prop('selected', true);
                    $('#inputAmount').val('');

                    if ($('#tItems').length !== 0) {
                        $('#tItems').remove();
                    }

                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                },
                error: function (error) {
                    if (error.status === 422) {
                        $.each(error.responseJSON.errors, function (i, error) {
                            let element = $(document).find('[name="' + i + '"]');

                            if (element.hasClass('is-invalid')) {
                                element.next('.invalid-feedback').text(error[0]);
                                return;
                            }

                            element.addClass('is-invalid');
                            element.after($('<div id="alert-items" class="invalid-feedback">' + error[0] + '</div>'));
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Algo de errado aconteceu!',
                            text: error.responseJSON.message
                        });
                    }
                }
            });
        });

        $("#inputType").change(function () {
            var selectedState = $(this).children("option:selected").val();
            $('#inputItem').children('option:not(:first)').remove();
            $('#inputItem').children('option:first').prop('selected', true);

            $.ajax({
                url: "{{ route('borrowing.select') }}",
                method: "GET",
                data: {id: selectedState},
                context: 'json',
                success: function (data) {
                    data.map(_data => {
                        $('#inputItem').append($('<option>', {
                            value: _data.id,
                            text: _data.name
                        }));
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>

@stop
