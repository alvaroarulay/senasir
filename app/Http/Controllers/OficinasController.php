<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oficinas;
use App\Models\Actual;
use App\Models\Responsables;
use App\Models\Unidadadmin;

class OficinasController extends Controller
{
    public function index(Request $request)
    {
        
            $oficinas = Oficinas::select('id','nomofic','observ','estado')
            ->where('unidad','=',$request->unidad)->get();
       
        return [
            'oficinas' => $oficinas
        ];
    }
    public function store(Request $request){
        
        try {
            $oficina = new Oficinas();
            $oficina->unidad = $request->unidad;
            $oficina->nomofic = $request->nomofic;
            $oficina->observ = $request->observ;
            $oficina->usuar = \Auth::user()->name;
            $oficina->estado = $request->estado;
            $oficina->save();
            
        } 
        catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
        return response()->json(['message' => 'Oficina Creada Correctamente!!!','idunidad'=>$oficina->unidad]);
    }
    public function update(Request $request){
        try {

            $oficina = Oficinas::findOrFail($request->id);
            $oficina->nomofic = $request->nomofic;
            $oficina->observ = $request->observ;
            $oficina->usuar = \Auth::user()->name;
            $oficina->estado = $request->estado;
            $oficina->save();

            return response()->json(['message' => 'Datos Actualizados Correctamente!!!','unidad'=>$oficina->unidad]);

        } catch (Exception $e) {

            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
        
    }
    public function activar(Request $request){
        try {

            $oficina = Oficinas::findOrFail($request->id);
            $oficina->estado = 1;
            $oficina->save();

            return response()->json(['message' => 'Oficina activada!!!','id'=>$oficina->id]);

        } catch (Exception $e) {

            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }
    public function desactivar(Request $request){
        try {

            $oficina = Oficinas::findOrFail($request->id);
            $oficina->estado = 0;
            $oficina->save();

            return response()->json(['message' => 'Oficina desactivada!!!','id'=>$oficina->id]);

        } catch (Exception $e) {

            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
    }
}
