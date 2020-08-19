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
                                    <option value="">Aluno</option>
                                    <option value="">Coordenador</option>
                                    <option value="">Funcionário</option>
                                    <option value="">Professor</option>
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
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputType">Tipo</label>
                                <select id="inputType" class="form-control">
                                    <option selected>Escolher...</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputItem">Item</label>
                                <select id="inputItem" class="form-control" name="item_id">
                                    <option selected>Escolher...</option>
{{--                                    @foreach($items as $item)--}}
{{--                                        <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="inputAmount">Quantidade</label>
                                <input type="text" class="form-control" id="inputAmount" name="amount"
                                       placeholder="0">
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
                                    <option selected>Escolher...</option>
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

        $("#inputType").change(function() {
            var estadoSelecionado = $(this).children("option:selected").val();

            $.ajax({
                url: "{{ route('borrowing.select') }}",
                method: "GET",
                dataType: "HTML",
                data: { id: estadoSelecionado }
            }).done(function(data){

                data.map(_data => {
                    _data.map(__data => {
                        $('#inputItem').append($('<option>', {
                            value: __data.id,
                            text: __data.name
                        }));
                    });
                });

            }).fail(function(resposta){
                alert(resposta)
            });
        });
    </script>

@stop
