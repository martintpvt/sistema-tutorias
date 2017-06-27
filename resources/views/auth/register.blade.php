@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('lastname') ? 'has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Lastname</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cedula') ? ' has-error' : '' }}">
                            <label for="cedula" class="col-md-4 control-label">Cédula</label>

                            <div class="col-md-6">
                                <input id="cedula" type="text" class="form-control" name="cedula" value="{{ old('cedula') }}" required>

                                @if ($errors->has('cedula'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cedula') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Role</label>
                            <div class="col-md-6">
                                <select id="role" name="role" class="form-control">
                                <?php
                                    foreach($roles as $key => $value)
                                    {
                                        $html = '<option value="'.$key.'"';
                                        if(old('role') == $key)
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
                        
                        <div class="form-group{{ $errors->has('facultad') ? ' has-error' : '' }}">
                            <label for="facultad" class="col-md-4 control-label">Facultad</label>
                            <div class="col-md-6">
                                <select id="facultad" name="facultad" class="form-control">
                                <?php
                                    foreach($facultades as $key => $value)
                                    {
                                        $html = '<option value="'.$key.'"';
                                        if(old('facultad') == $key)
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

                        <div class="form-group{{ $errors->has('carrera') ? ' has-error' : '' }}">
                            <label for="carrera" class="col-md-4 control-label">Carrera</label>
                            <div class="col-md-6">
                                <select id="carrera" name="carrera" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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

    $(document).ready(function()
    {
        cargarCarreras();

        <?php 
            if(Session()->get('estado') != null)
            {
                echo 'alert("'.Session()->get('estado').'")';
            }
        ?>

        $("#facultad").change(function()
        {
            cargarCarreras();
        });
    });

</script>
@endsection
