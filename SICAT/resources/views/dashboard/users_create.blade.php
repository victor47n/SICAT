@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
    <h1>Funcionários</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href={{route('welcome')}}>Home</a></li>
    <li class="breadcrumb-item active">Funcionários</li>
    <li class="breadcrumb-item active">Cadastrar</li>
@stop

@section('content')
<div class="row  justify-content-center">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Cadastrar funcionário</h3>
      </div>

      <form id="form">
        {{ csrf_field() }}

        <div class="card-body">
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name"
              placeholder="Nome">
          </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@abc.xyz">
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
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

@section('plugins.Sweetalert2', true)

@section('js')
<script>
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

 $("#form").on("submit", function(e){
    e.preventDefault();

    $.ajax({
      url:  "{{route('user.add')}}",
      method: "POST",
      dataType: 'json',
      data: $('#form').serialize(),
      success: function(data){
        Toast.fire({
          type: 'success',
          title: data.message
        });
      }
    });
  });
</script>

@stop
