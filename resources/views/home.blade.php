@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Buscar horario
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('cargarHorario') }}">
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

                        <div class="form-group">
                            <label for="carrera" class="col-md-4 control-label">Carrera</label>
                            <div class="col-md-6">
                                <select id="carrera" name="carrera" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="docente" class="col-md-4 control-label">Docente</label>
                            <div class="col-md-6">
                                <select id="docente" name="docente" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="submit-btn" type="submit" class="btn btn-primary">
                                    Cargar Horario
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
    function cargarCarreras()
    {
        $.get("/carreras/" + $("#facultad").val(), function(response, state)
        {
            $("#carrera").empty();

            if(response.length > 0)
            {
                $("#carrera").prop('disabled', false);

                for(i = 0; i < response.length; i++)
                {
                    $("#carrera").append("<option value='" + response[i].Id_Carrera + "'>" + response[i].NombreCarrera + "</option>");
                }
            } else {
                $("#carrera").prop('disabled', true);
            }
        });
    }

    function cargarDocentes()
    {
        $.get("/docentes/" + $("#carrera").val(), function(response, state)
        {
            $("#docente").empty();

            if(response.length > 0)
            {
                $("#docente").prop('disabled', false);

                for(i = 0; i < response.length; i++)
                {
                    $("#docente").append("<option value='" + response[i].id + "'>" + response[i].name + " " + response[i].lastname + "</option>");
                }
            } else {
                $("#docente").prop('disabled', true);

            }
        });
    }

    $(document).ready(function()
    {
        cargarCarreras();
        cargarDocentes();

        $("#facultad").change(function()
        {
            cargarCarreras();
            cargarDocentes();
        });

        $("#carrera").change(function()
        {
            cargarDocentes();
        });
    });
</script>
@endsection
