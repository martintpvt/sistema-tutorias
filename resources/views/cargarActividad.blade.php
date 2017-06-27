@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cargar Horario</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('subirActividad') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="docente" value="{{ $docente }}">
                        <input type="hidden" name="dia" value="{{ $dia }}">
                        <input type="hidden" name="modulo" value="{{ $modulo }}">
                        
                        <div class="form-group">
                            <label for="actividad" class="col-md-4 control-label">Actividad</label>
                            <div class="col-md-6">
                                <select id="actividad" name="actividad" class="form-control">
                                <?php
                                    foreach($actividades as $key => $value)
                                    {
                                        $html = '<option value="'.$value->Id_Actividad.'"';

                                        if($value->EspecificarUbicacion == 1)
                                        {
                                            $html .= ' class="activarUbicaicon"';
                                        } else {
                                            $html .= ' class="desactivarUbicacion"';
                                        }

                                        if(old('actividad') == $value->Id_Actividad)
                                        {
                                            $html .= ' selected';
                                        }
                                        $html .= '>'.$value->NombreActividad.'</option>';

                                        echo $html;
                                    }
                                ?>
                                </select>

                                @if ($errors->has('actividad'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('actividad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div id="ubicacion">
                            <div class="form-group">
                                <label for="sede" class="col-md-4 control-label">Sede</label>
                                <div class="col-md-6">
                                    <select id="sede" name="sede" class="form-control">
                                        <?php
                                        foreach($sedes as $key => $value)
                                        {
                                            $html = '<option value="'.$key.'"';
                                            if(old('sede') == $key)
                                            {
                                                $html .= ' selected';
                                            }
                                            $html .= '>'.$value.'</option>';

                                            echo $html;
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('aula') ? 'has-error' : '' }}">
                                <label for="aula" class="col-md-4 control-label">Aula</label>

                                <div class="col-md-6">
                                    <input id="aula" type="text" class="form-control" name="aula" value="{{ old('aula') }}">

                                    @if ($errors->has('aula'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('aula') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Subir Actividad
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        @if(Session('estado') != null)
            alert("{{ Session('estado') }}");
        @endif
            
        $("#actividad").change(function()
        {
            @foreach($actividades as $key => $value)
                if($("#actividad").val() == {{ $value->Id_Actividad }})
                {
                    @if($value->EspecificarUbicacion)
                        $("#aula").prop('required', true);
                        $("#ubicacion").show();
                    @else
                        $("#aula").prop('required', false);
                        $("#ubicacion").hide();
                    @endif
                    if({{ $value->EspecificarUbicacion }} == 1)
                    {
                        
                    }
                    else
                    {
                        
                    }
                }
            @endforeach
        });
    });
</script>
@endsection
