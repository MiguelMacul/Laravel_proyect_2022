@extends('layouts.layout')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-info">
                        {{Session::get('success')}}
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Editar empleado</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('empleado.update',$empleado->id) }}"  role="form">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="nombre" id="nombre" class="form-control input-sm" value="{{$empleado->nombre}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="puesto" id="puesto" class="form-control input-sm" value="{{$empleado->puesto}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="sueldo" id="sueldo" class="form-control input-sm" value="{{$empleado->sueldo}}" pattern="[0-9]+">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="tipo_moneda" id="tipo_moneda" class="form-control input-sm" >
                                                <option value="{{$empleado->tipo_moneda}}"> {{$empleado->tipo_moneda}} </option>
                                                @if(isset($monedas))   
                                                    @foreach ($monedas as  $moneda)
                                                        <option value="{{$moneda}}"> {{$moneda}} </option>
                                                     @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="edad" id="edad" class="form-control input-sm" value="{{$empleado->edad}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="estado_residencia" id="estado_residencia" class="form-control input-sm" >
                                                @if(isset($estados)) 
                                                 <option value="{{$empleado->estado_residencia}}"> {{$empleado->estado_residencia}} </option>  
                                                    @foreach ($estados as  $estado)
                                                        <option value="{{$estado->nombre}}"> {{$estado->nombre}} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label>Activo</label>
                                            <input type="checkbox" name="activo" id="activo" class="form-control input-sm" value="{{$empleado->activo}}"
                                                    {{$empleado->activo == 1 ? 'checked' : ''}}>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit"  value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('empleado.index') }}" class="btn btn-info btn-block" >Atrás</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
@endsection