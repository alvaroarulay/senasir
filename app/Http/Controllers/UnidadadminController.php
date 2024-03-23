<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidadadmin;
use App\Models\CodigoContable;

class UnidadadminController extends Controller
{
  
    public function index()
    {
        $unidad = Unidadadmin::All();
        return [
            'unidad' => $unidad
        ];
    }
    public function store(Request $request)
    {
        $grupocontable = array(
                                "EDIFICACIONES"=>40,
                                "MUEBLES Y ENSERES DE OFICINA" =>10,
                                "MAQUINARIA EN GENERAL" =>8,
                                "EQUIPO MÉDICO Y LABORATORIO" =>8,
                                "EQUIPO DE COMUNICACIONES" =>8,
                                "EQUIPO EDUCACIONAL Y RECREATIVO" =>8,
                                "BARCOS Y LANCHAS EN GENERAL" =>10,
                                "VEHICULOS AUTOMOTORES" =>5,
                                "AVIONES" =>5,
                                "MAQUINARIA PARA LA CONSTRUCCIÓN" =>5,
                                "MAQUINARIA AGRICOLA" =>4,
                                "ANIMALES DE TRABAJO" =>4,
                                "HERRAMIENTAS EN GENERAL" =>4,
                                "REPRODUCTORES Y HEMBRAS DE PEDIGREE" =>8,
                                "EQUIPOS DE COMPUTACION" =>4,
                                "CANALES DE REGADIO Y POZOS" =>20,
                                "ESTANQUES, BAÑADEROS Y ABREVADEROS" =>10,
                                "ALAMBRADOS, TRANQUERAS Y VALLAS" =>10,
                                "VIVIENDAS PARA EL PERSONAL" =>20,
                                "MUEBLES Y ENSERES EN VIVIENDAS DE PERSONAL" =>10,
                                "SILOS, ALMACENES Y GALPONES" =>20,
                                "TINGLADOS Y COBERTIZOS DE MADERA" =>5,
                                "TINGLADOS Y COBERTIZOS DE METAL" =>10,
                                "INSTALACIÓN DE ELECTRIFICACIÓN Y TELEFONIA RURAL" =>10,
                                "CAMINOS INTERIORES" =>10,
                                "CAÑA DE AZUCAR" =>5,
                                "VIDES" =>10,
                                "FRUTALES" =>10,
                                "POZOS PETROLEROS" =>5,
                                "LINEAS DE RECOLECCIÓN DE LA INDUSTRIA PETROLERA" =>5,
                                "EQUIPOS DE CAMPO DE LA INDUSTRIA PETROLERA" =>8,
                                "PLANTA DE PROCESAMIENTO DE LA INDUSTRIA PETROLERA" =>8,
                                "DUCTOS DE LA INDUSTRIA PETROLERA" =>10,
                                "TERRENOS" =>0,
                                "OTROS ACTIVOS FIJOS" =>0,
                                "ACTIVOS INTANGIBLES" =>5,
                                "EQUIPO E INSTALACIONES" =>8,
                                "OTRAS PLANTACIONES" =>8,
                                "ACTIVOS MUSEOLOGICOS Y CULTURALES" =>0,
                                );
        try {
            $unidad = new Unidadadmin();
            $unidad->entidad=1;
            $unidad->unidad=$request->unidad;
            $unidad->descrip=$request->descripcion;
            $unidad->ciudad=$request->departamento;
            $unidad->estado=$request->estado; 
            $unidad->save();

            
            
            foreach($grupocontable as $nombre => $vida){
                
                    $grupo = new CodigoContable();
                    $grupo->unidad=$unidad->id;
                    $grupo->nombre=$nombre;
                    $grupo->vidautil=$vida;
                    $grupo->observ='NINGUNA'; 
                    $grupo->depreciar= 1;
                    $grupo->actualizar= 1;
                    $grupo->usuar= \Auth::user()->name;
                    $grupo->save();
                
            };
         } catch (Exception $e) {
             return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
         }
         
         return response()->json(['message' => 'Datos Registrados Correctamente!!!']);
        
    }
    public function update(Request $request){
        
        try {
            
            $unidad = Unidadadmin::find($request->id);
            $unidad->unidad=$request->unidad;
            $unidad->descrip=$request->descripcion;
            $unidad->ciudad=$request->departamento;
            $unidad->estado=$request->estado;
            $unidad->save();
         
         } catch (Exception $e) {
             return response()->json(['message' => 'Excepción capturada: '+  $e->getMessage()]);
         }
         
         return response()->json(['message' => 'Datos Actualizados Correctamente!!!']);
    }
    public function selectUnidad(){
        $unidad = Unidadadmin::select('id','unidad','descrip')->where('estado','=',1)->get();
        return['unidad'=>$unidad];
    }
}
