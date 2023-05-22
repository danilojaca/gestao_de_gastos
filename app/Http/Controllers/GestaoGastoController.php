<?php

namespace App\Http\Controllers;

use App\Models\GestaoGasto;
use App\Models\Mes;
use App\Models\Salario;
use App\Models\Economia;
use Illuminate\Http\Request;

class GestaoGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request, GestaoGasto $gestaogastos)
    {   $soma = "0";
        $restante = "0";
        $economia = "0";
        $input_mes= "";
        $economias = Economia::all(['economia'])->toArray();  
        $e = array_column($economias,'economia'); 
        $economia = array_sum($e);        


        $meses = $request->input('mes');
        $mes = Mes::orderBy('id')->get();
        $salario = Salario::where([['mes_id', $request->input('mes')]])->get();
        $y = $salario->toArray();
        $x = array_column($y,'salario');
        $salarios = array_sum($x); 


        $gastos = $gestaogastos->where([
            ['mes_id', $request->input('mes')]
        ])->get();        
        
        if (isset($meses)) { 
           $valores = $gastos->toArray();
           $valor = array_column($valores,'valores');
           $soma = array_sum($valor); 

           $r = $gestaogastos->where([            
            ['pago','1'],
            ['mes_id', $request->input('mes')]
        ])->get();
           
        
            $s = $r->toArray();
            $a = array_column($s,'valores');
            $resto = array_sum($a);

           

           $restante = ($salarios - $resto);
           $input_mes= $request->input('mes');
    }

        return view('mes',[ 'gastos' => $gastos,'mes' => $mes,'soma' => $soma,'salarios' => $salarios, 'restante' => $restante, 'economia' => $economia,'input_mes' => $input_mes,'gestaogastos' => $gestaogastos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gastos = $request->input('gastos');
        $salario = $request->input('salario');
        $saved = $request->input('economia'); 
        
    if(isset($salario)){
        //dd($request->all());
        Salario::create($request->all());
    }
    
    elseif (isset($saved)) {
        $rules = [
            'mes_id' => 'unique:economias',
        ];

        $feedback = [
            'unique' => 'money this month has already been saved '
        ];
        $request->validate($rules,$feedback);

        Economia::create($request->all());
    }else {
        GestaoGasto::create($request->all());
    }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GestaoGasto $gestaogastos, Request $request)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GestaoGasto $gestao)
    {
        //dd($gestao);
        $gestao->update($request->all());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GestaoGasto $gestao)
    {   
        //dd($gestao);
        $gestao->delete();

        return redirect()->back();
    }
    
   
}
