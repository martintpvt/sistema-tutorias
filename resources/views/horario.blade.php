@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Horario
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">
                    Horario Semestre 2017-2
                </div>
                <div class="col-md-12">
                    Docente: {{ $nombre.' '.$apellido }}
                </div>
                <div class="col-md-12">
                    Facultad: {{ $facultad }}
                </div>
                <div class="col-md-12">
                    Carrera: {{ $carrera }}
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="panel panel-default table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>HORA</th>
                                        @foreach($dias as $key => $value)
                                        <th>{{ $value }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulos as $key => $value)
                                    <tr>
                                        <td>{{ $value }}</td>
                                        @foreach($dias as $llave => $valor)
                                        <td>
                                            <?php
                                            $texto = '';    

                                            foreach($actividades as $indice => $actividad)
                                            {
                                                if($actividad['dia'] == $valor && $actividad['modulo'] == $value)
                                                {
                                                    $texto .= $actividad['actividad'];

                                                    if($actividad['especificarUbicacion'] == 1)
                                                    {
                                                        $texto .= ' / '.$actividad['sede'].' '.$actividad['aula'];
                                                    }
                                                }
                                            }

                                            if($texto != '')
                                            {
                                                echo $texto;
                                            }
                                            ?>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
