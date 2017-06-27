<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Ubicacion;
use App\DocenteActividad;

class HorarioController extends Controller
{
    protected function crearUbicacion($data)
    {
        return Ubicacion::create([
            'Id_Dia' => $data['Id_Dia'],
            'Id_Modulo' => $data['Id_Modulo'],
            'Id_Sede' => $data['Id_Sede'],
            'Aula' => $data['Aula']
        ]);
    }
    
    protected function crearDocenteActividad($data)
    {
        $ubicacionActual = DB::table('ubicaciones')->where('Id_Ubicacion', $data['Id_Ubicacion'])->first();

        $dia = $ubicacionActual->Id_Dia;
        $modulo = $ubicacionActual->Id_Modulo;

        $actividades = DB::table('docenteactividad')->where('Id_Docente', $data['Id_Docente'])->get();

        $ubicacionAntigua = '';

        foreach($actividades as $key => $value)
        {
            $ubicacion = DB::table('ubicaciones')->where('Id_Ubicacion', $value->Id_Ubicacion)->first();

            if($ubicacion->Id_Dia == $dia && $ubicacion->Id_Modulo == $modulo)
            {
                $ubicacionAntigua = $ubicacion;
                break;
            }
        }

        if($ubicacionAntigua != '')
        {
            $result = DB::table('docenteactividad')->where([
                ['Id_Docente', $data['Id_Docente']],
                ['Id_Ubicacion', $ubicacionAntigua->Id_Ubicacion]
            ])->update([
                'Id_Ubicacion' => $data['Id_Ubicacion'],
                'Id_Actividad' => $data['Id_Actividad']
            ]);
        } else {
            $result = DocenteActividad::create([
                'Id_Docente' => $data['Id_Docente'],
                'Id_Ubicacion' => $data['Id_Ubicacion'],
                'Id_Actividad' => $data['Id_Actividad']
            ]);
        }

        return $result;
    }
    
    public function index()
    {
        if(Auth::check() && Auth::user()->role == 3)
        {
            $docentesDB = DB::table('users')->where([
                ['carrera', Auth::user()->carrera],
                ['role', 2]
            ])->orWhere([
                ['carrera', Auth::user()->carrera],
                ['role', 3]
            ])->get();

            $docentes = array();

            foreach($docentesDB as $key => $value)
            {
                $docentes[$value->id] = $value->name.' '.$value->lastname;
            }

            /*
            $docentesDB = DB::table('users')->where([
                ['carrera', Auth::user()->carrera],
                ['role', 2]    
            ])->orWhere([
                ['carrera', Auth::user()->carrera],
                ['role', 3]    
            ])->get();
            $docentes = array();

            $actividades = DB::table('actividades')->get();
            $sedesDB = DB::table('sedes')->get();
            $modulosDB = DB::table('modulos')->get();
            $diasDB = DB::table('dias')->get();
            
            $sedes = array();
            $modulos = array();
            $dias = array();
            
            foreach($sedesDB as $key => $value)
            {
                $sedes[$value->Id_Sede] = $value->NombreSede;
            }
            
            foreach($modulosDB as $key => $value)
            {
                $modulos[$value->Id_Modulo] = $value->Modulo;
            }
            
            foreach($diasDB as $key => $value)
            {
                $dias[$value->Id_Dia] = $value->Dia;
            }

            foreach($docentesDB as $key => $value)
            {
                $docentes[$value->id] = $value->name.' '.$value->lastname;
            }
            
            return view('/cargarHorario', [
                'actividades' => $actividades, 
                'sedes' => $sedes, 
                'modulos' => $modulos, 
                'dias' => $dias, 
                'docentes' => $docentes
            ]);
            */

            return view('/cargarHorario', ['docentes' => $docentes]);
        }
        else
        {
            return Redirect::to(route('home'));
        }
    }
    
    public function cargarActividad($Id_Docente, $dia, $modulo)
    {
        $actividades = DB::table('actividades')->get();
        $sedesDB = DB::table('sedes')->get();

        foreach($sedesDB as $key => $value)
        {
            $sedes[$value->Id_Sede] = $value->NombreSede;
        }

        return view('/cargarActividad', [
            'docente' => $Id_Docente,
            'dia' => $dia,
            'modulo' => $modulo,
            'actividades' => $actividades,
            'sedes' => $sedes
        ]);
        /*
        $data = Input::all();
        $result = $this->subirActividad($data);

        if($result == 1)
        {
            Session::flash('estado', 'Datos ingresados correctamente');
            return Redirect::route('cargarHorario');
        } else if($result == 2) {
            Session::flash('estado', 'Algo salio mal');
            return Redirect::route('cargarHorario');
        } else if($result == 3) {
            Session::flash('estado', 'El docente se encuentra ocupado en ese momento');
            return Redirect::route('cargarHorario');
        } else if($result['codigo'] == 4) {
            return Redirect::to('/cargarHorario')->withInput()->withErrors($response['data']);
        }
        */
    }

    public function horario($Id_Docente)
    {
        $docente = DB::table('users')->where('id', $Id_Docente)->first();
        $carrera = DB::table('carreras')->where('Id_Carrera', $docente->carrera)->first();
        $facultad = DB::table('facultades')->where('Id_Facultad', $carrera->Id_Facultad)->first()->NombreFacultad;
                
        $data = $this->getHorario($Id_Docente);
        
        return view('/horario', [
            'nombre' => $docente->name,
            'apellido' => $docente->lastname,
            'facultad' => $facultad, 
            'carrera' => $carrera->NombreCarrera, 
            'dias' => $data['dias'], 
            'modulos' => $data['modulos'], 
            'actividades' => $data['actividades']
        ]);
    }

    public function horarioLinks($Id_Docente)
    {
        $data = $this->getHorario($Id_Docente);

        $html = '<table class="table table-striped table-bordered table-responsive">';
        $html .= '<thead><tr><th>HORA</th>';

        foreach($data['dias'] as $key => $value)
        {
            $html .= '<th>';
            $html .= $value;
            $html .= '</th>';
        }

        $html .= '</tr></thead>';

        $html .= '<tbody>';

        foreach($data['modulos'] as $key => $value)
        {
            $html .= '<tr><td>';
            $html .= $value;
            $html .= '</td>';

            foreach($data['dias'] as $llave => $valor)
            {
                $html .= '<td><a href="/cargarActividad/'.$Id_Docente.'/'.$llave.'/'.$key.'">';

                $texto = '';

                foreach($data['actividades'] as $indice => $actividad)
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
                    $html .= $texto;
                } else {
                    $html .= '&nbsp;';
                }

                $html .= '</a></td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return $html;

        /*
        <table class="table table-striped table-bordered table-responsive">
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
                        else
                            echo '&nbsp;';
                        ?>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        */
    }

    public function cargarHorario()
    {
        $data = Input::all();

        if(isset($data['docente']))
        {
            return Redirect::route('horario', $data['docente']);
        }
        else
        {
            return Redirect::route('home');
        }
    }

    public function agregarActividad()
    {
        $data = Input::all();
        $result = $this->subirActividad($data);

        if($result == 1)
        {
            Session::flash('docente', $data['docente']);
            return Redirect::route('cargarHorario');
        } else if($result == 2) {
            Session::flash('estado', 'Algo salio mal');
            return Redirect::route('cargarHorario');
        } else if($result == 3) {
            Session::flash('estado', 'El docente se encuentra ocupado en ese momento');
            return Redirect::route('cargarHorario');
        } else if($result['codigo'] == 4) {
            return Redirect::to('/cargarActividad')->withInput()->withErrors($response['data']);
        }
    }

    protected function subirActividad($data)
    {
        $rules = array(
            'docente' => 'required',
            'modulo' => 'required',
            'dia' => 'required',
            'actividad' => 'required'
        );
        
        $validator = Validator::make($data, $rules);

        if($validator->fails())
        {
            return ['codigo' => 4, 'data' => $validator];
        } else {
            $datosUbicacion = ['Id_Dia' => $data['dia'], 'Id_Modulo' => $data['modulo'], 'Id_Sede' => $data['sede'], 'Aula' => $data['aula']];
            
            $ubicacion = DB::table('ubicaciones')->where([
                ['Id_Dia', $data['dia']],
                ['Id_Modulo', $data['modulo']],
                ['Id_Sede', $data['sede']],
                ['Aula', $data['aula']]
            ])->first();

            if(count($ubicacion) == 0)
            {
                $this->crearUbicacion($datosUbicacion);

                $ubicacion = DB::table('ubicaciones')->where([
                    ['Id_Dia', $data['dia']],
                    ['Id_Modulo', $data['modulo']],
                    ['Id_Sede', $data['sede']],
                    ['Aula', $data['aula']]
                ])->first();
            }
            
            $ubicacionId = $ubicacion->Id_Ubicacion;
            
            $datosDocenteActividad = ['Id_Docente' => $data['docente'], 'Id_Ubicacion' => $ubicacionId, 'Id_Actividad' => $data['actividad']];

            if($this->crearDocenteActividad($datosDocenteActividad))
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }
    }

    protected function getHorario($Id_Docente)
    {
        $diasDB = DB::table('dias')->get();
        $modulosDB = DB::table('modulos')->get();
        $docenteActividad = DB::table('docenteactividad')->where('Id_Docente', $Id_Docente)->get();
        
        $dias = array();
        $modulos = array();
        
        foreach($diasDB as $key => $value)
        {
            $dias[$value->Id_Dia] = $value->Dia;
        }
        
        foreach($modulosDB as $key => $value)
        {
            $modulos[$value->Id_Modulo] = $value->Modulo;
        }
        
        $actividades = array();
        
        foreach($docenteActividad as $key => $value)
        {
            $actividad = DB::table('actividades')->where('Id_Actividad', $value->Id_Actividad)->first();
            $ubicacion = DB::table('ubicaciones')->where('Id_Ubicacion', $value->Id_Ubicacion)->first();
            
            $dia = DB::table('dias')->where('Id_Dia', $ubicacion->Id_Dia)->first()->Dia;
            $modulo = DB::table('modulos')->where('Id_Modulo', $ubicacion->Id_Modulo)->first()->Modulo;
            $sede = DB::table('sedes')->where('Id_Sede', $ubicacion->Id_Sede)->first()->NombreSede;
            $aula = $ubicacion->Aula;
            
            $actividades[$key]['actividad'] = $actividad->NombreActividad;
            $actividades[$key]['especificarUbicacion'] = $actividad->EspecificarUbicacion;
            $actividades[$key]['dia'] = $dia;
            $actividades[$key]['modulo'] = $modulo;
            $actividades[$key]['sede'] = $sede;
            $actividades[$key]['aula'] = $aula;
        }

        $data = array();

        $data['dias'] = $dias;
        $data['modulos'] = $modulos;
        $data['actividades'] = $actividades;

        return $data;
    }
}
