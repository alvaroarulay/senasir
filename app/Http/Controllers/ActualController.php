<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Actual;
use App\Models\CodigoContable;
use App\Models\Auxiliares;
use App\Models\Oficinas;
use App\Models\Responsables;
use App\Models\Unidadadmin;
use App\Models\Logs;
use App\Models\Image;
use App\Models\Asignaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jenssegers\Date\Date;

class ActualController extends Controller
{
    public function index(Request $request)
    {   
        //if (!$request->ajax()) return redirect('/');
        //$grupocontable = CodigoContable::All();
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $actuales = Actual::join('auxiliar','actual.codaux','=','auxiliar.id')
            ->join('codcont','auxiliar.codcont','=','codcont.id')
            ->join('unidadadmin','unidadadmin.id','=','codcont.unidad')
            ->join('resp','actual.codresp','=','resp.id')
            ->join('oficina','resp.codofic','=','oficina.id')
            ->select('actual.id','actual.codigo','codcont.nombre','unidadadmin.id as idunidad','unidadadmin.unidad',
            'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp','codcont.id as idcontable',
            'actual.descripcion','actual.estado','actual.estadoasignacion','auxiliar.id as idauxiliar',
            'actual.codsec','actual.observ')->paginate(5);
        }
        else{
            $actuales = Actual::join('auxiliar','actual.codaux','=','auxiliar.id')
            ->join('codcont','auxiliar.codcont','=','codcont.id')
            ->join('unidadadmin','unidadadmin.id','=','codcont.unidad')
            ->join('resp','actual.codresp','=','resp.id')
            ->join('oficina','resp.codofic','=','oficina.id')
            ->select('actual.id','actual.codigo','codcont.nombre','unidadadmin.id as idunidad','unidadadmin.unidad',
            'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp','codcont.id as idcontable',
            'actual.descripcion','actual.estado','actual.estadoasignacion','auxiliar.id as idauxiliar',
            'actual.codsec','actual.observ')
            ->where('actual.'.$criterio, 'like', '%'. $buscar . '%')->paginate(5);           
        }
        //return view('actuales.lista', ['actuales' => $actuales,'unidad'=>$unidad]);
        return [
        'pagination' => [
            'total'        => $actuales->total(),
            'current_page' => $actuales->currentPage(),
            'per_page'     => $actuales->perPage(),
            'last_page'    => $actuales->lastPage(),
            'from'         => $actuales->firstItem(),
            'to'           => $actuales->lastItem(),
        ],
        'actuales'=>$actuales,
        //'grupocontable'=>$grupocontable
        ];

    }
    public function store(Request $request){
        Date::setLocale('es');
        $fechDerecha = Date::now()->format('d/M/Y');
        try {
            $actual = new Actual();
            $actual->codigo = $request->codigo_nuevo;
            $actual->codsec = $request->codigo_sec;
            $actual->codarpro = $request->codigo_arpro;
            $actual->codaux = $request->id_aux;
            $actual->vidautil = $request->vida_util;
            $actual->descripcion = $request->descripcion_inicial;
            $actual->costo = $request->costo_inicial;
            $actual->codresp = $request->id_responsable;
            $actual->observ = $request->observ_inicial;
            $actual->estado = $request->estado_nuevo;
            $actual->codbien = $request->id_bien;
            $actual->nroconv = $request->nro_convenio;
            $actual->orgfin = 2;
            $actual->usuar = \Auth::user()->username;
            $actual->estadoasignacion = 1;
            $actual->incorporacion = $request->fecha_incorporacion;
            $actual->save();
                    
         } catch (Exception $e) {
             return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
         }
         
         return response()->json(['message' => 'Datos Registrados Correctamente!!!','id' => $actual->id]);
    }
    public function show($id)
    {
        $actual = Actual::join('auxiliar','actual.codaux','=','auxiliar.id')
        ->join('codcont','auxiliar.codcont','=','codcont.id')
        ->join('resp','actual.codresp','=','resp.id')
        ->join('oficina','resp.codofic','=','oficina.id')
        ->select('actual.id','actual.codigo','codcont.nombre','actual.costo','actual.incorporacion','actual.updated_at',
        'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp',
        'actual.descripcion','actual.estado','actual.estadoasignacion',
        'actual.codsec','actual.observ')->where('actual.id','=',$id)->first();
        return ['actual'=>$actual];
    }
    public function update(Request $request)
    {
    //if (!$request->ajax()) return redirect('/');

        $articuloant = Actual::where('id','=',$request->id)->first();
        $codActualizar = $request->id;
        $contcodaux = $articuloant->codaux != $request->codaux ? true : false;
        $contdescripcion = $articuloant->descripcion != $request->descripcion ? true : false;
        $contobserv = $articuloant->observ != $request->observacion ? true : false;
        $contcodestado = $articuloant->estado != $request->estado ? true : false;
        
        $articulo = Actual::findOrFail($request->id);
        $articulo->codaux = $request->codaux;
        $articulo->descripcion = $request->descripcion;
        $articulo->observ = $request->observacion;
        $articulo->estado = $request->estado;
        $articulo->save();

       
        if ($contcodaux){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Auxliar';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contdescripcion){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico la Descripción del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contobserv){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico la observación del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };
        if ($contcodestado){
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Estado del Activo';
        $logs->user = auth()->user()->name;
        $logs->save();
        };

        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);

    }
    public function updateResponasable(Request $request){
        $articuloant = Actual::where('id','=',$request->id)->first();
        $codoficina = \Auth::user()->codofic;
        $codresponsable = \Auth::user()->codresp;

        $asignacion = New Asignaciones();
        $asignacion->codactual = $request->id;
        $asignacion->codresp = $articuloant->codresp ;
        $asignacion->codofic = $articuloant->codofic;
        $asignacion->usuario = \Auth::user()->name;
        $asignacion->save();
                
        $articulo = Actual::findOrFail($request->id);
        $articulo->codresp = $codresponsable;
        $articulo->codofic = $codoficina;
        $articulo->estadoasignacion = 0;
        $articulo->save();
        
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Responsable y Oficina';
        $logs->user = \Auth::user()->name;
        $logs->save();

        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function imprimir($id){
      
        $actual = Actual::find($id);
        $qr = QrCode::generate('http://senasirprueba.test/actuales/veractual/'.$actual->id);
        $pdf = \PDF::loadView('plantillapdf.pdf',compact('actual','qr'));
        $pdf->set_paper("A8", "landscape");
        return $pdf->download('acitvo'.$actual->id.'.pdf');
    }
    public function verinvitado($id){
        $actual = Actual::join('auxiliar','actual.codaux','=','auxiliar.id')
        ->join('codcont','auxiliar.codcont','=','codcont.id')
        ->join('resp','actual.codresp','=','resp.id')
        ->join('oficina','resp.codofic','=','oficina.id')
        ->select('actual.id','actual.codigo','codcont.nombre','actual.costo','actual.incorporacion','actual.updated_at',
        'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp',
        'actual.descripcion','actual.estado','actual.estadoasignacion',
        'actual.codsec','actual.observ')->where('actual.id','=',$id)->first();

        $images = Image::where('CODACTUAL','=',$id)->get();
        return view('actuales.actualver', ['actual' => $actual,'images' => $images]);
    }
    
    public function reporteActivos()
    {   
        //if (!$request->ajax()) return redirect('/');
        
        $unidad = Unidadadmin::where('estado','=','1')->first();

        $actuales = Actual::join('codcont','actual.codcont','=','codcont.codcont')
        ->join('auxiliar',function ($join) {
        $join->on('actual.codaux', '=', 'auxiliar.codaux');
            $join->on('actual.unidad', '=', 'auxiliar.unidad');
            $join->on('actual.codcont', '=', 'auxiliar.codcont');
        })
        ->join('oficina',function ($join) {
        $join->on('actual.codofic', '=', 'oficina.codofic');
            $join->on('actual.unidad', '=', 'oficina.unidad');
        })
        ->join('resp',function ($join) {
        $join->on('actual.codresp', '=', 'resp.codresp');
            $join->on('actual.codofic', '=', 'resp.codofic');
            $join->on('actual.unidad', '=', 'resp.unidad');
        })
        ->join('estado','actual.codestado','=','estado.codestado')
        ->select('actual.id','actual.unidad','actual.codigo','codcont.nombre',
        'auxiliar.nomaux','actual.vidautil','oficina.nomofic','resp.nomresp',
        'actual.descripcion','estado.nomestado','actual.estadoasignacion',
        'actual.codigosec','actual.observ','actual.codcont','actual.codaux')
        ->where('actual.unidad','=',$unidad->unidad)->get();     
        return response()->json(['actuales'=>$actuales]);
    }
    public function buscarActivos(Request $request){
        $data = $request->filtro;
        $unidad = Unidadadmin::where('estado','=','1')->first();
        $actuales = Actual::where('codigo','=',$data)->first();
        return response()->json(['actuales'=>$actuales]);
    }
    public function buscarActivoResp(Request $request){
        $codresp = $request->codresp;
        $codofic = $request->codofic;
        $unidad = Unidadadmin::where('estado','=','1')->first();
        $actuales = Actual::join('oficina','oficina.codofic','=','actual.codofic')
                    ->join('auxiliar',function ($join) {
                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                            $join->on('actual.unidad', '=', 'auxiliar.unidad');
                            $join->on('actual.codcont', '=', 'auxiliar.codcont');
                    })
                    ->join('estado','actual.codestado','=','estado.id')
                    ->select('actual.id','actual.unidad','actual.codigo','actual.codresp','actual.codofic',
                    'actual.codaux','auxiliar.nomaux','estado.nomestado',
                    'actual.vidautil','oficina.nomofic',
                    'actual.descripcion','actual.codestado','actual.estadoasignacion',
                    'actual.codigosec','actual.observ')
                    ->where('actual.codresp','=',$codresp)
                    ->where('actual.codofic','=',$codofic)->get();
        return response()->json(['actuales'=>$actuales]);
    }
    public function updateAsignacion(Request $request){
        $articuloant = Actual::where('id','=',$request->id)->first();

        $asignacion = New Asignaciones();
        $asignacion->codactual = $request->id;
        $asignacion->codresp = $articuloant->codresp;
        $asignacion->usuario = \Auth::user()->name;
        $asignacion->save();
                
        $articulo = Actual::findOrFail($request->id);
        $articulo->codresp = $request->id;
        $articulo->save();
        
        $logs = new Logs();
        $logs->codactual = $request->id;
        $logs->descripcion = 'Se Modifico el Responsable.';
        $logs->user = \Auth::user()->name;
        $logs->save();
        
        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function repAsignaciones(Request $request){
        
        Date::setLocale('es');
        $fechaTitulo = Date::now()->format('l j F Y');
        $fechDerecha = Date::now()->format('d/M/Y');
        $datos = Actual::join('auxiliar','actual.codaux', '=', 'auxiliar.id')
                                    ->select('actual.codigo','actual.codaux','auxiliar.nomaux','actual.estado', 'actual.descripcion',)
                                    ->where('actual.codresp','=',$request->codresp)->get();
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.id')
                                    ->select('resp.nomresp','oficina.nomofic','resp.cargo','oficina.id','resp.ci','resp.expedicion')
                                    ->where('resp.id','=',$request->codresp)->first();
        $total = $datos->count();
        $pdf=Pdf::loadView('plantillapdf.repAsignacion',['datos'=>$datos,'responsable'=>$responsable,'fechaTitulo'=>$fechaTitulo,'fechaDerecha'=>$fechDerecha,'total'=>$total]);
        $pdf->set_paper(array(0,0,800,617));
        return $pdf->download();
        
    }
    public function repDevoluciones(Request $request){
        
        Date::setLocale('es');
        $fechaTitulo = Date::now()->format('l j F Y');
        $fechDerecha = Date::now()->format('d/M/Y');
        $datos = Asignaciones::join('actual','actual.id','=','asignacion.codactual')
                                    ->join('auxiliar',function ($join) {
                                        $join->on('actual.codaux', '=', 'auxiliar.codaux');
                                            $join->on('actual.unidad', '=', 'auxiliar.unidad');
                                            $join->on('actual.codcont', '=', 'auxiliar.codcont');
                                    })
                                    ->join('estado','actual.codestado','=','estado.id')
                                    ->select('actual.codigo','actual.codaux','auxiliar.nomaux','estado.nomestado', 'actual.descripcion',)
                                    ->where('asignacion.codresp','=',$request->codresp)
                                    ->where('asignacion.codofic','=',$request->codofic)->get();
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
                                    ->join('cla_depts','resp.cod_exp','=','cla_depts.id')
                                    ->select('resp.nomresp','oficina.nomofic','resp.cargo','oficina.codofic','resp.ci','cla_depts.sigla')
                                    ->where('resp.codresp','=',$request->codresp)
                                    ->where('resp.codofic','=',$request->codofic)->first();
        $total = $datos->count();
        $pdf=Pdf::loadView('plantillapdf.repDevolucion',['datos'=>$datos,'responsable'=>$responsable,'fechaTitulo'=>$fechaTitulo,'fechaDerecha'=>$fechDerecha,'total'=>$total]);
        $pdf->set_paper(array(0,0,800,617));
        return $pdf->download();
        
    }
    public function buscarActivoEstado(Request $request){  
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $actuales = Actual::select('id','codigo','codresp','descripcion','estado')->where('estadoasignacion','=','0')->paginate(5);
        }
        else{
            $actuales = Actual::select('id','codigo','codresp','descripcion','estado')->where('estadoasignacion','=','0')->where('actual.'.$criterio, 'like', '%'. $buscar . '%')->paginate(5);
        }
        return [
                'pagination' => [
                    'total'        => $actuales->total(),
                    'current_page' => $actuales->currentPage(),
                    'per_page'     => $actuales->perPage(),
                    'last_page'    => $actuales->lastPage(),
                    'from'         => $actuales->firstItem(),
                    'to'           => $actuales->lastItem(),
                ],
                'actuales'=>$actuales,
                ];
    }
}
