@extends('adminlte::page')

@section('title', 'SICAT')

@section('content_header')
<h1>Página inicial</h1>
@stop

@section('breadcrumb')
<li class="breadcrumb-item"><a href={{route('dashboard.index')}}>Home</a></li>
@stop

@section('content')

<div class="row">
    <h5>Ordens de Serviço</h5>
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$quantOSTotal}}</h3>

                <p>Total</p>
            </div>
            <div class="icon">
                <i class="fas icon-book-open"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$quantOSFinalizados}}</h3>

                <p>Finalizado</p>
            </div>
            <div class="icon">
                <i class="fas icon-check"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$quantOSPendentes}}</h3>

                <p>Pendente</p>
            </div>
            <div class="icon">
                <i class="fas icon-flag"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$quantOSAtrasados}}</h3>

                <p>Atrasados</p>
            </div>
            <div class="icon">
                <i class="fas icon-exclamation"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Ultimas Ordens de Serviço ? </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Numero da OS</th>
                                <th>Tarefa</th>
                                <th>Local</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($os) >=1)
                            @foreach ($os as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->problem_type}}</td>
                                <td>{{$item->workstation}}</td>
                                <td>{{$item->status}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="4">Sem tarefas designadas a você</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{route('order.index')}}" class="btn btn-sm btn-info float-left">Ver ordens de serviço</a>
                <a href="{{route('order.create')}}" class="btn btn-sm btn-secondary float-right">Criar ordem de
                    serviço</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Com prazo encerrando</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Numero da OS</th>
                                <th>Tarefa</th>
                                <th>Local</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($osAtrasadas) >=1)
                            @foreach ($osAtrasadas as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->problem_type}}</td>
                                <td>{{$item->workstation}}</td>
                                <td>{{$item->status}}</td>
                            </tr>
                            @endforeach

                            @else
                            <tr>
                                <td class="text-center" colspan="4">Sem tarefas se encerrando</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="{{route('order.index')}}" class="btn btn-sm btn-info float-left">Ver ordens de serviço</a>
                <a href="{{route('order.create')}}" class="btn btn-sm btn-secondary float-right">Criar ordem de
                    serviço</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>

<div class="row">
    <h5>Empréstimos</h5>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>

                <p>Total</p>
            </div>
            <div class="icon">
                <i class="fas icon-book-open"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>50</h3>

                <p>Devolvidos</p>
            </div>
            <div class="icon">
                <i class="fas icon-check"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>50</h3>

                <p>Emprestados</p>
            </div>
            <div class="icon">
                <i class="fas icon-flag"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>50</h3>

                <p>Atrasados</p>
            </div>
            <div class="icon">
                <i class="fas icon-exclamation"></i>
            </div>
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

@section('js')
<script>
</script>
@stop