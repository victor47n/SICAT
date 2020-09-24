@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Ordens de serviço</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
    <li class="breadcrumb-item active">Ordens de serviço</li>
    <li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
    <div class="row  justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar ordem de serviço</h3>
                </div>

                <form id="osForm">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group  col-md-12">
                                <label for="name">Descrição</label>
                                <input type="text" class="form-control" id="problem" name="problem"
                                       placeholder="Descreva o problema">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Problema</label>
                                <select class="form-control custom-select" id="problem_type" name="problem_type">
                                    <option value="" selected disabled hidden>Escolher...</option>
                                    <option value="Software">Software</option>
                                    <option value="Hardware">Hardware</option>
                                    <option value="Sistema Operacional">Sistema Operacional</option>
                                    <option value="Rede">Rede</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Local</label>
                                <select class="form-control custom-select" id="locale_id" name="locale_id">
                                    <option value="" selected disabled hidden>Escolher...</option>

                                    @foreach ($locales as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Posto de Trabalho</label>
                                <select class="form-control custom-select" disabled id="workstation_id"
                                        name="workstation_id">

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Data de realização</label>
                                <input type="date" class="form-control" name="realized_date" id="realized_date" value="{{ date("Y-m-d", strtotime("-1 days")) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Funcionário designado</label>
                                <select class="form-control custom-select" id="designated_employee"
                                        name="designated_employee">
                                    <option value selected disabled hidden>Escolher...</option>
                                    @foreach ($employee as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Status</label>
                                <select class="form-control custom-select" id="status_id" name="status_id" disabled>
                                    <option selected value="{{ $status->id }}">{{ $status->name }}</option>
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
            $('#osForm').validate({
                rules: {
                    problem: {
                        required: true,
                    },
                    problem_type: {
                        required: true,
                    },
                    locale_id: {
                        required: true,
                    },
                    workstation_id: {
                        required: true,
                    },
                    realized_date: {
                        required: true,
                    },
                    status_id: {
                        required: true,
                    }
                },
                messages: {
                    problem: {
                        required: "O campo descrição do problema é obrigatório.",
                    },
                    problem_type: {
                        required: "O tipo do problema é obrigatório.",
                    },
                    locale_id: {
                        required: "O local é obrigatório.",
                    },
                    workstation_id: {
                        required: "O posto de trabalho é obrigatório.",
                    },
                    realized_date: {
                        required: "O campo data de realização é obrigatório.",
                    },
                    status_id: {
                        required: "O status da ordem de serviço é obrigatório.",
                    }
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

            let a = 0;

            $("#locale_id").change(function (e) {
                e.preventDefault();
                $.ajax({
                    url: `/locais/${$("#locale_id").val()}/workstations`,
                    method: "GET",
                    dataType: 'json',
                    data: $('#osForm').serialize(),
                    success: function (data) {
                        console.log(data);
                        workstations = data.data;
                        $("#workstation_id").html("").removeAttr("disabled");

                        workstations.forEach(element => {
                            $("#workstation_id").append(`<option value="${element.id}">${element.name}</option>`)
                        });
                    }
                });
            });

            $("#osForm").on("submit", function (e) {
                e.preventDefault();

                let data = {
                    problem: $('#problem').val(),
                    problem_type: $('#problem_type').val(),
                    locale_id: $('#locale_id').val(),
                    workstation_id: $('#workstation_id').val(),
                    realized_date: $('#realized_date').val(),
                    designated_employee: $('#designated_employee').val(),
                    status_id: $('#status_id').val(),
                }

                $.ajax({
                    url: "{{route('order.store')}}",
                    method: "POST",
                    dataType: 'json',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
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
                            Toast.fire({
                                type: 'error',
                                title: error.responseJSON.message
                            });
                        }
                    }
                });
            });
        });
    </script>

@stop
