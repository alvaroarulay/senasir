<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Responsables;
use App\Models\Unidadadmin;
use App\Models\Actual;
use App\Models\User;


class ResponsablesController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $responsables = Responsables::join('oficina', 'resp.codofic','=','oficina.id')
            ->join('unidadadmin', 'unidadadmin.id','=','oficina.unidad')
            ->select('resp.nomresp','resp.ci','resp.expedicion','resp.cargo','oficina.nomofic','unidadadmin.unidad','resp.estado')
            ->paginate(10);
        }
        else{
            $responsables = Responsables::join('oficina', 'resp.codofic','=','oficina.id')
            ->join('unidadadmin', 'unidadadmin.id','=','oficina.unidad')
            ->select('resp.nomresp','resp.ci','resp.expedicion','resp.cargo','oficina.nomofic','unidadadmin.unidad','resp.estado')
            ->where('resp.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('resp.id', 'desc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $responsables->total(),
                'current_page' => $responsables->currentPage(),
                'per_page'     => $responsables->perPage(),
                'last_page'    => $responsables->lastPage(),
                'from'         => $responsables->firstItem(),
                'to'           => $responsables->lastItem(),
            ],
            'responsables' => $responsables
        ];
       
    }
    public function listarResponsable(Request $request)
    {
         $responsables = Responsables::join('users','resp.id','=','users.codresp')
         ->select('resp.id','resp.nomresp','resp.cargo','resp.observ','resp.ci','resp.expedicion','resp.inicio','resp.fin','resp.estado','users.username','users.email','users.idrol')
         ->where('resp.codofic','=',$request->id)->paginate(5);

        return [
            'pagination' => [
                'total'        => $responsables->total(),
                'current_page' => $responsables->currentPage(),
                'per_page'     => $responsables->perPage(),
                'last_page'    => $responsables->lastPage(),
                'from'         => $responsables->firstItem(),
                'to'           => $responsables->lastItem(),
            ],
            'responsables' => $responsables
        ];
    }
    public function listarRespActivo(Request $request){
        
        $responsables = Responsables::where('codofic','=',$request->id)->where('estado','=',1)->get();
        return ['responsables' => $responsables];
    }
    public function store(Request $request)
    {
        try {
            $responsable = new Responsables();
            $responsable->codofic = $request->codofic;
            $responsable->nomresp = $request->nomresp;
            $responsable->cargo = $request->cargo;
            $responsable->observ = $request->observ;
            $responsable->ci = $request->ci;
            $responsable->usuar = \Auth::user()->username;
            $responsable->expedicion = $request->expedido;
            $responsable->estado = $request->estado;
            $responsable->inicio=Carbon::parse($request->inicio);
            $responsable->fin=Carbon::parse($request->fin);
            $responsable->save();

            $user = new User();
            $user->name = $request->nomresp;
            $user->email=$request->email;
            $user->username = $request->user;
            $user->password = Hash::make( $request->ci);
            $user->condicion = 1;
            $user->codresp = $responsable->id;    
            $user->idrol = $request->idrol;
            $user->save();
        
            return response()->json(['message' => 'Datos Guardados Correctamente!!!','codofic'=>$responsable->codofic]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        try {
            $responsable = Responsables::findOrFail($request->id);
            $responsable->codofic = $request->codofic;
            $responsable->nomresp = $request->nomresp;
            $responsable->cargo = $request->cargo;
            $responsable->observ = $request->observ;
            $responsable->ci = $request->ci;
            $responsable->expedicion = $request->expedido;
            $responsable->estado = $request->estado;
            $responsable->inicio=Carbon::parse($request->inicio);
            $responsable->fin=Carbon::parse($request->fin);
            $responsable->save();

            $user = User::where('codresp','=',$request->id)->firstOrFail();
            $user->name = $request->nomresp;
            $user->email=$request->email;
            $user->username = $request->user;  
            $user->idrol = $request->idrol;
            $user->save();

            return response()->json(['message' => 'Datos Actualizados Correctamente!!!','codofic'=>$responsable->codofic]);
            
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
        
       
    }
    
    public function buscarResponsable(Request $request){

        //if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.codofic')
        ->where('resp.ci','=', $filtro)
        ->select('resp.id','resp.nomresp','resp.cargo','oficina.nomofic','resp.api_estado','resp.codresp','resp.codofic')->first();
        return response()->json(['responsable' => $responsable]);
    }
    
    public function delete(Request $request){
        //echo (intval($request->codresp));
        $activo = Actual::where('codresp','=',$request->codresp)->where('codofic','=',$request->codofic)->get();
        $activo = $activo->count();
        if($activo==0){
            $res=Responsables::where('id',$request->id)->delete();

            $table = new TableEditor(public_path('dbfs\RESP.dbf'),['encoding' => 'cp1251']);

            while ($record = $table->nextRecord()) {
                if ($record->get('codofic')==$request->codofic && $record->get('codresp')==$request->codresp) {
                    $table->deleteRecord(); //mark record deleted
                }    
            }

            $table->pack()->save()->close();

            return response()->json(['message' => 'Responsable Eliminado Exitosamente !!!']);
        }else{
            return response()->json(['message' => 'El Usuario tiene '.$activo.' Activos asignados, no se puede Eliminar!!!']);
        }
        
    }
    public function repResponsables(){
        $responsable = Responsables::join('oficina','resp.codofic','=','oficina.id')
                                    ->select('resp.nomresp','resp.ci','oficina.nomofic','resp.cargo',
                                    'resp.observ',)->get();
        return response()->json(['responsable' => $responsable]);                      
    }

    
}
