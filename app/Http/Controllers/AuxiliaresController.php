<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auxiliares;
use App\Models\Unidadadmin;

class AuxiliaresController extends Controller
{
   
    public function index(Request $request)
    {
        $id = $request->id;
        
        if ($id==''){
            $auxiliares = Auxiliares::select('auxiliar.id','auxiliar.nomaux','auxiliar.observ')->paginate(10);
        }
        else{
            $auxiliares = Auxiliares::select('auxiliar.id','auxiliar.nomaux','auxiliar.observ')
            ->where('auxiliar.codcont','=',$id)->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $auxiliares->total(),
                'current_page' => $auxiliares->currentPage(),
                'per_page'     => $auxiliares->perPage(),
                'last_page'    => $auxiliares->lastPage(),
                'from'         => $auxiliares->firstItem(),
                'to'           => $auxiliares->lastItem(),
            ],
            'auxiliares' => $auxiliares
        ];
    }
    public function listarAuxiliar(Request $request)
    {
        $auxiliares = Auxiliares::where('codcont','=',$request->id)->get();

        return ['auxiliares' => $auxiliares];
    }
    public function store(Request $request)
    {
        try {
            $auxiliar = new Auxiliares();
            $auxiliar->codcont = $request->codcont;
            $auxiliar->nomaux = $request->nomaux;
            $auxiliar->observ = $request->observ;
            $auxiliar->usuar = \Auth::user()->name;
            $auxiliar->save();
         } catch (Exception $e) {
             return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
         }
         
         return response()->json(['message' => 'Datos Registrados Correctamente!!!','codcont' => $auxiliar->codcont]);
        
    }
    public function update(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $auxiliar = Auxiliares::find($request->id);
        $auxiliar->nomaux = $request->nomaux;
        $auxiliar->codcont = $request->codcont;
        $auxiliar->save();

        try {
           $table = new TableEditor(public_path('dbfs\AUXILIAR.dbf'),['encoding' => 'cp1252']);
        
        while ($record = $table->nextRecord()){
            if($record->get('codcont') == "$request->codcont" && $record->get('codaux') == "$request->codaux"){
                $record->set('nomaux',"$request->nomaux");
                $record->set('codcont',"$request->codcont");
                $table->writeRecord();
            }
        }
        $table->save()->close();
        } catch (Exception $e) {
            return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
        }
        
        return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
}
