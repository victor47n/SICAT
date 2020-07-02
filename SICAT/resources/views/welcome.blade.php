@extends('adminlte::page')

@section('title', 'Página inicial')

@section('content_header')
    <h1>Página inicial</h1>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('footer')
    <div class="float-right d-none d-sm-inline">
        <strong>Versão</strong> 1.0
    </div>
    <strong>Copyright &copy; {{date("Y")}} <a href="#">Carlos A. & Victor H</a>.</strong> Todos os direitos reservados.
@stop

@section('css')
{{--    <link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
