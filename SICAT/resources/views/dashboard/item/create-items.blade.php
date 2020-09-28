@extends('adminlte::page')

@section('title', 'Itens')

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
        <div class="col-sm-12 col-md-8 col-lg-4 col-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar itens</h3>
                </div>

                <form id="form">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-12">
                                <label for="inputName">Nome</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputAmount">Quantidade</label>
                                <input type="text" class="form-control" id="inputAmount" name="amount"
                                       placeholder="">
                            </div>
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputType">Tipo de item</label>
                                <select id="inputType" class="form-control" name="type_id">
                                    <option selected disabled>Escolher...</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
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
@section('plugins.Validation', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        $(document).ready(function () {
            $('#inputAmount').inputmask({
                alias: 'numeric',
                allowMinus: true,
                min: 0,
                digits: 0,
                showMaskOnFocus: false,
                showMaskOnHover: false,
            });

            $('#bForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    amount: {
                        required: true,
                        digits: true,
                    },
                    type_id: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: "O campo nome é obrigatório.",
                    },
                    amount: {
                        required: "A quantidade é obrigatória.",
                        email: "Por favor, insira uma quantidade válida."
                    },
                    type_id: {
                        required: "O tipo é obrigatório.",
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

        $("#form").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('item.store') }}",
                method: "POST",
                dataType: 'json',
                data: $('#form').serialize(),
                success: function (data) {
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });

                    $('#inputName').val('');
                    $('#inputAmount').val('');
                    $('#inputType').children('option:first').prop('selected', true);
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
    </script>

@stop
