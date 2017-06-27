@extends('layouts.app')

<?php 
    $old_docente = '';

    if(Session('docente') != null)
    {
        $old_docente = Session('docente');
    }
?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cargar Horario</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="docente" class="col-md-4 control-label">Docente</label>
                        <div class="col-md-6">
                            <select id="docente" name="docente" class="form-control">
                                <?php
                                    foreach($docentes as $key => $value)
                                    {
                                        $html = '<option value="'.$key.'"';
                                        if(old('docente') == $key || $old_docente == $key)
                                        {
                                            $html .= ' selected';
                                        }
                                        $html .= '>'.$value.'</option>';

                                        echo $html;
                                    }
                                ?>
                            </select>

                            @if ($errors->has('docente'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('docente') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">&nbsp;</div>

                    <div class="col-md-12">
                        <div id="table-container" class="panel panel-default table-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarHorario()
    {
        $("#table-container").empty();

        $.ajax({
            url: "/horarioLinks/" + $("#docente").val(),
            type: "GET",
            dataType: "html",
            success: function (data) {
                //var result = $('<div />').append(data).find('#showresults').html();
                //$('#showresults').html(result);
                $("#table-container").append(data);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('slow')
            }
        });
    }

    $(document).ready(function()
    {
        @if(Session('estado') != null)
            alert("{{ Session('estado') }}");
        @endif

        cargarHorario();

        $("#docente").change(function()
        {
            cargarHorario();
        });
    });
</script>
@endsection
