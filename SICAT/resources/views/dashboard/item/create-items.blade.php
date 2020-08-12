@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Itens</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Itens</li>
    <li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
    <div class="row  justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar itens</h3>
                </div>

                <form id="form">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                       placeholder="">
                            </div>
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputType">Tipo de item</label>
                                <select id="inputType" class="form-control" name="type_id">
                                    <option selected>Escolher...</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputAmount">Quantidade</label>
                                <input type="text" class="form-control" id="inputAmount" name="amount"
                                       placeholder="">
                            </div>
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" class="form-control" name="status_id">
                                    <option selected>Escolher...</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->id}}">{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
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
                url: "{{ route('user.store') }}",
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
    </script>

@stop
