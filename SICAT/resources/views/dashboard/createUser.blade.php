@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
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
              placeholder="Insira o nome completo do funcionário">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Insira o endereço de e-mail">
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
          title: data.mensagem
        });
      }
    });
  });
</script>

@stop