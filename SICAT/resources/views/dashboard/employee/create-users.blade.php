@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Funcionários</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Funcionários</li>
    <li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar funcionário</h3>
                </div>

                <form id="uForm">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="name"
                                   placeholder="Nome">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                       placeholder="exemplo@abc.xyz">
                            </div>
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="inputPassword">Senha</label>
                                <input type="password" class="form-control" id="inputPassword" name="password"
                                       placeholder="Senha">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputPhone">Telefone</label>
                                <input type="text" class="form-control" id="inputPhone" name="phone"
                                       placeholder="(99) 99999-9999">
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputOffice">Cargo</label>
                                <select id="inputOffice" class="form-control custom-select" name="office">
                                    <option selected disabled value>Escolher...</option>
                                    <option>Funcionário</option>
                                    <option>Estagiário</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-lg-4">
                                <label for="inputRole">Nivel de permissão</label>
                                <select id="inputRole" class="form-control custom-select" name="role_id">
                                    <option selected disabled value>Escolher...</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
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

@section('plugins.Validation', true)
@section('plugins.Inputmask', true)
@section('plugins.Sweetalert2', true)

@section('js')
    <script>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function () {
            $('#inputPhone').inputmask('(99) 9999[9]-9999', {
                showMaskOnFocus: false,
                showMaskOnHover: false,
                removeMaskOnSubmit: true,
                autoUnmask: true
            });

            $('#uForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8
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
                    password: {
                        required: "O campo senha é obrigatório.",
                        minlength: "A senha deve ter no mínimo 8 caracteres."
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

            $("#uForm").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('user.store') }}",
                    method: "POST",
                    dataType: 'json',
                    data: $('#uForm').serialize(),
                    success: function (data) {
                        $('#inputName').val('');
                        $('#inputEmail').val('');
                        $('#inputPassword').val('');
                        $('#inputPhone').val('');
                        $('#inputOffice').children('option:first').prop('selected', true);
                        $('#inputRole').children('option:first').prop('selected', true);

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
        });
    </script>

@stop
