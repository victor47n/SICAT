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
                                       placeholder="Nome">
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputOffice">Cargo</label>
                                <select id="inputOffice" class="form-control" name="office_requester">
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
                                       placeholder="exemplo@abc.xyz">
                            </div>
                            <div class="form-group col-4">
                                <label for="inputPhone">Telefone</label>
                                <input type="text" class="form-control" id="inputPhone" name="phone_requester"
                                       placeholder="(99) 99999-9999">
                            </div>
                        </div>
                        <div id="fItems">
                            <div class="form-row" id="item-row">
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputType-0">Tipo</label>
                                    <select id="inputType-0" class="form-control" onchange="populateItemSelect(0)">
                                        <option selected disabled>Escolher...</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-4">
                                    <label for="inputItem-0">Item</label>
                                    <select id="inputItem-0" class="form-control" name="item_id[]" data-index="0">
                                        <option selected disabled>Escolher...</option>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label for="inputAmount">Quantidade</label>
                                    <input type="text" class="form-control" id="inputAmount-0" name="amount[]"
                                           placeholder="0">
                                </div>

                                <div class="form-group d-flex justify-content-center align-items-end col-lg-2">
                                    <div class="btn-group" role="group" aria-label="Exemplo básico">
                                        <button id="addItem" type="button" class="btn btn-info"><i
                                                class="fas fa-fw fa-plus"></i></button>
                                        <button id="delete" type="button" class="btn btn-danger"><i
                                                class="fas fa-fw fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputDateA">Data de aquisição</label>
                                <input type="text" class="form-control" id="inputDate" name="acquisition_date"
                                       placeholder="dd/mm/aaaa">
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputDataR">Data de devolução</label>
                                <input type="text" class="form-control" id="inputdataR" name="return_date"
                                       placeholder="dd/mm/aaaa">
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" class="form-control" name="status_id">
                                    <option selected disabled>Escolher...</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
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
            const fieldItem = $("#item-row").clone(true, true);
            let a = 0;

            $("div").on('click', '#delete', function () {
                console.log($("#delete").parents());
                $(this).parents()[2].remove();
            });

            // $("#addItem").on('click', function () {
            //     console.log(fieldItem);
            //     a++;
            //     let t = fieldItem.clone(true, true);
            //     t.attr('id', 'item-row-' + a);
            //
            //     // t.children()[1].attr('id', '-'+a);
            //     // console.log(t.children()[1].getElementById('inputItem'));
            //
            //     $("#teste").append(t);
            // });

            $("#addItem").on('click', function(){
                a++;
                let html = '';
                html += '<div class="form-row" id="item-row">\n' +
                    '                                <div class="form-group col-md-12 col-lg-4">\n' +
                    '                                    <label for="inputType-'+a+'">Tipo</label>\n' +
                    '                                    <select id="inputType-'+a+'" class="form-control" onchange="populateItemSelect('+a+')">\n' +
                    '                                        <option selected disabled>Escolher...</option>\n' +
                    '                                        @foreach($types as $type)\n' +
                    '                                            <option value="{{ $type->id }}">{{ $type->name }}</option>\n' +
                    '                                        @endforeach\n' +
                    '                                    </select>\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group col-md-12 col-lg-4">\n' +
                    '                                    <label for="inputItem-'+a+'">Item</label>\n' +
                    '                                    <select id="inputItem-'+a+'" class="form-control" name="item_id[]">\n' +
                    '                                        <option selected disabled>Escolher...</option>\n' +
                    '                                    </select>\n' +
                    '                                </div>\n' +
                    '                                <div class="form-group col-2">\n' +
                    '                                    <label for="inputAmount">Quantidade</label>\n' +
                    '                                    <input type="text" class="form-control" id="inputAmount-'+a+'" name="amount[]"\n' +
                    '                                           placeholder="0">\n' +
                    '                                </div>\n' +
                    '\n' +
                    '                                <div class="form-group d-flex justify-content-center align-items-end col-lg-2">\n' +
                    '                                    <div class="btn-group" role="group" aria-label="Opções">\n' +
                    '                                        <button id="addItem" type="button" class="btn btn-info"><i\n' +
                    '                                                class="fas fa-fw fa-plus"></i></button>\n' +
                    '                                        <button id="delete" type="button" class="btn btn-danger"><i\n' +
                    '                                                class="fas fa-fw fa-minus"></i></button>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>';
                $('#fItems').append(html);
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

        function populateItemSelect(a) {
            var estadoSelecionado = $('#inputType-'+a).children("option:selected").val();
            console.log(estadoSelecionado);
            $('#inputItem-'+a).children('option:not(:first)').remove();
            $('#inputItem-'+a).children('option:first').prop('selected', true);
            // $("#inputItem").html('<option selected disabled>Escolher...</option>');

            $.ajax({
                url: "{{ route('borrowing.select') }}",
                method: "GET",
                data: {id: estadoSelecionado},
                context: 'json',
                success: function (data) {
                    data.map(_data => {
                        $('#inputItem-'+a).append($('<option>', {
                            value: _data.id,
                            text: _data.name
                        }));
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    </script>

@stop
