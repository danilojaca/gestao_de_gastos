<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GestaoGasto;
use App\Models\Mes;
use App\Models\Salario;
use App\Models\Economia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GestaoGasto $gestaogastos)
    {   $economia = "0";
        $economias = Economia::all(['economia'])->toArray();  
        $e = array_column($economias,'economia'); 
        $economia = array_sum($e);  

        $date = date('m');
        if (date('m') < '10') {
            $data = $date[1];
        }else {
            $data = $date;
        }
        
        $avisos = $gestaogastos->where([
            ['mes_id',$data]
        ])->get();

        

        $r = $gestaogastos->where([            
            ['pago',NULL],
            ['mes_id', $data]
        ])->get();
           
        
            $s = $r->toArray();
            $a = array_column($s,'valores');
            $resto = array_sum($a);


        return view('home',[ 'avisos' => $avisos,'economia' => $economia,'resto' => $resto]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
