@extends('layouts.app')

@section('content')
<div class="container p-4 d-flex align-items-center justify-content-center ">
    <div class="col-md-6  alert alert-warning  ">
        <div class="row g-2">
                <div class="col-md-3">
                    @if ($economia <= '8000' )                
                    <span class="text-dark">
                    @else 
                    <span class="text-success">
                    @endif 
                    <strong >Total Saved</strong>: € {{$economia}}</span>
                    
                </div>
                <div class="col-md-7">
                
                </div>
                <div class="col-md-2">
                @if ($economia >= '8000')
                    <span class="text-success" >
                @else
                    <span class="text-dark" >
                @endif
                    €{{$economia - '8000'}} <strong>Left</strong></span>
                </div>
                <!--Aviso contas nao Pagas-->
                <div class="col-md-12">
                     @foreach ( $avisos as $aviso )
                     @if($aviso->pago == NULL)                                        
                    <span class="text-danger"><strong>Month  {{$aviso->mes->mes}}: {{$aviso->gastos}} was not paid</strong></span> 
                    <br>
                     @endif
                     @endforeach                     
                </div>
                @if(isset($resto))    
                <div class="col-md-6">
                @if ($resto == '0')
                 <span class="text-success">   
                @else
                <span class="text-danger"> 
                @endif
                 Amount to be Paid in the Month {{date('M') }}:<strong> € {{$resto}}</strong></span>
                </div>
                 @endif
                
        </div>
    </div>
</div>
@endsection
