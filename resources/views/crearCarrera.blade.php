@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Insertar Carrera:</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('cargarCarreras') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="facultad" class="col-md-4 control-label">Facultad</label>
                            <div class="col-md-6">
                                <select id="facultad" name="facultad" class="form-control">
                                    @foreach($facultades as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('carrera') ? 'has-error' : '' }}">
                            <label for="carrera" class="col-md-4 control-label">Carrera</label>

                            <div class="col-md-6">
                                <input id="carrera" type="text" class="form-control" name="carrera" value="{{ old('carrera') }}" required>

                                @if ($errors->has('carrera'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('carrera') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Ingresar Carrera
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
