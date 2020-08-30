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

                <form id="form">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-8">
                                <label for="inputName">Nome do requisitante</label>
                                <input type="text" class="form-control" id="inputName" name="requester"
                                       placeholder="Nome" required>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputOffice">Cargo</label>
                                <select id="inputOffice" class="form-control" name="office_requester" required>
                                    <option selected>Escolher...</option>
                                    <option value="Aluno">Aluno</option>
                                    <option value="Coordenador">Coordenador</option>
                                    <option value="Funcionário">Funcionário</option>
                                    <option value="Professor">Professor</option>
                                </select>
                            </div>
                            <div class="form-group col-8">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email_requester"
                                       placeholder="exemplo@abc.xyz" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="inputPhone">Telefone</label>
                                <input type="text" class="form-control" id="inputPhone" name="phone_requester"
                                       data-inputmask='"mask": "(99) 9999[9]-9999"' data-mask
                                       placeholder="(99) 99999-9999">
                            </div>
                        </div>
                        <div id="fItems">
                            <div class="form-row align-items-end" id="item-row-0">
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputType">Tipo</label>
                                    <select id="inputType" class="form-control" required>
                                        <option selected disabled value>Escolher...</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputItem">Item</label>
                                    <select id="inputItem" class="form-control" name="item_id" required>
                                        <option selected disabled>Escolher...</option>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label for="inputAmount">Quantidade</label>
                                    <input type="text" class="form-control" id="inputAmount" name="amount"
                                           placeholder="0" required>
                                </div>

                                <div class="col-auto mb-3">
                                    <button id="delete" type="button" class="btn btn-danger">
                                        <i class="fas fa-fw fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputDate">Data de aquisição</label>
                                <input type="date" class="form-control" id="inputDate" name="acquisition_date"
                                       placeholder="dd/mm/aaaa" required>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" class="form-control" name="status_id" required>
                                    <option selected disabled>Escolher...</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
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

@section('plugins.Inputmask', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $('[data-mask]').inputmask();

        $(document).ready(function () {

            let a = 0;

            $("div").on('click', '#delete', function () {
                $(this).parents()[1].remove();
            });

            $("#addItem").on('click', function () {
                {{--a++;--}}
                {{--let html = '';--}}
                {{--html += '<div class="form-row align-items-end" id="item-row-'+a+'">\n' +--}}
                {{--    '                                <div class="form-group col-md-12 col-lg-4">\n' +--}}
                {{--    '                                    <label for="inputType-' + a + '">Tipo</label>\n' +--}}
                {{--    '                                    <select id="inputType-' + a + '" class="form-control" onchange="populateItemSelect(' + a + ')">\n' +--}}
                {{--    '                                        <option selected disabled>Escolher...</option>\n' +--}}
                {{--    '                                        @foreach($types as $type)\n' +--}}
                {{--    '                                            <option value="{{ $type->id }}">{{ $type->name }}</option>\n' +--}}
                {{--    '                                        @endforeach\n' +--}}
                {{--    '                                    </select>\n' +--}}
                {{--    '                                </div>\n' +--}}
                {{--    '                                <div class="form-group col-md-12 col-lg-4">\n' +--}}
                {{--    '                                    <label for="inputItem-' + a + '">Item</label>\n' +--}}
                {{--    '                                    <select id="inputItem-' + a + '" class="form-control" name="item_id[]">\n' +--}}
                {{--    '                                        <option selected disabled>Escolher...</option>\n' +--}}
                {{--    '                                    </select>\n' +--}}
                {{--    '                                </div>\n' +--}}
                {{--    '                                <div class="form-group col-2">\n' +--}}
                {{--    '                                    <label for="inputAmount">Quantidade</label>\n' +--}}
                {{--    '                                    <input type="text" class="form-control" id="inputAmount-' + a + '" name="amount[]"\n' +--}}
                {{--    '                                           placeholder="0">\n' +--}}
                {{--    '                                </div>\n' +--}}
                {{--    '\n' +--}}
                {{--    '                                <div class="col-auto mb-3">\n' +--}}
                {{--    '                                        <button id="delete" type="button" class="btn btn-danger"><i\n' +--}}
                {{--    '                                                class="fas fa-fw fa-minus"></i></button>\n' +--}}
                {{--    '                                </div>\n' +--}}
                {{--    '                            </div>';--}}
                {{--$('#fItems').append(html);--}}

                // let type = {
                //                 id: $('#inputType')
                //                     .children("option:selected")
                //                     .val(),
                //                 name: $('#inputType')
                //                     .children("option:selected")
                //                     .text()
                //             };
                //
                // let item = {
                //                 id: $('#inputItem')
                //                     .children("option:selected")
                //                     .val(),
                //                 name: $('#inputItem')
                //                     .children("option:selected")
                //                     .text()
                //             };
                //
                // let amount = $('#inputAmount').val();

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

                // FAZER VERIFICAÇÃO SE O SELECT TA SEM SELECIONAR NADA
                // console.log(items);
                // console.log(Object.keys(items));
                // console.log(Object.values(items));

                if ($('#tItems').length === 0)
                {
                    let tItems = '<table id="tItems" class="table table-sm table-borderless">' +
                                    '<thead class="thead-dark">' +
                                        '<tr role="row">\n' +
                                            '<th scope="col">Tipo</th>\n' +
                                            '<th scope="col">Item</th>\n' +
                                            '<th scope="col">Quantidade</th>\n' +
                                            '<th scope="col">Excluir</th>\n' +
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                    '</tbody>';

                    $('#fItems').append(tItems);
                }

                $('#tItems tbody:last-child').append(
                    '<tr>' +
                        '<td id="'+items.type_id+'">'+items.type_name+'</td>' +
                        '<td id="'+items.item_id+'">'+items.item_name+'</td>' +
                        '<td>'+items.amount+'</td>' +
                    '</tr>'
                );

            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $("#form").on("submit", function (e) {
            e.preventDefault();

            console.log($('#form').serialize());

            $.ajax({
                url: "{{ route('borrowing.store') }}",
                method: "POST",
                dataType: 'json',
                data: $('#form').serialize(),
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                },
                error: function (data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Algo de errado aconteceu!',
                        text: data.responseJSON.message
                    });
                }
            });
        });

        $("#inputType").change(function() {
            var estadoSelecionado = $(this).children("option:selected").val();
            $('#inputItem').children('option:not(:first)').remove();
            $('#inputItem').children('option:first').prop('selected', true);

            $.ajax({
                url: "{{ route('borrowing.select') }}",
                method: "GET",
                data: {id: estadoSelecionado},
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
