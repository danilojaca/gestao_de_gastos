@extends('layouts.app')

@section('content')
<div class="container m-1 p-0">
    <div class="row">
        <div class="col-sm-8">
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-7">
                        <div class="form-floating">           
                            <form method="GET" action="{{ route('gestao.index') }}">
                            <select class="form-select" name="mes" >
                            <option data-default disabled selected >Selecione o Mes</option>
                            @foreach ( $mes as $x )
                            <option value="{{$x->id}}" {{$x->id  == $input_mes ? 'selected' : ''}}>{{$x->mes}}</option>  
                            @endforeach
                            </select>                                    
                        </div>
                    </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mt-">Submit</button>
                            <a href='{{ route('gestao.index') }}' class="btn btn-primary">Clear</a>
                        </div>    
                            </form>
                </div> 
            </div> 
            <hr>
            <div class="container mt-">                                
                <table class="table table-bordered">
                <tr>
                    <th>{{'Gastos'}}</th>
                    <th colspan="2">{{'Valores'}}</th>
                    <th>{{'Salario'}}</th>
                    <td>{{$salarios}}</td>
                </tr>            
                @foreach ( $gastos as $gestaogasto )
                <tr>   
                    <form  class="row g-3" action={{route('gestao.update', ['gestao' => $gestaogasto->id])}} method='POST' >
                    @method('PUT')
                    @csrf          
                    <td><input type="text" class="form-control-plaintext" name="gastos" value={{$gestaogasto->gastos}}></td>
                    <td><input type="text" class="form-control-plaintext" name="valores" value={{$gestaogasto->valores}}></td>
                    <td><input type="checkbox" class="form-check-input" name="pago" value='1' {{$gestaogasto->pago  == '1' ? 'checked' : ''}}></td>                
                    <td >
                    <button class="btn btn-outline-light text-dark" type="submit">Editar</button> 
                    </form>
                    </td>
                    <td >
                    <form  action={{route('gestao.destroy', ['gestao' => $gestaogasto->id])}} method='POST'>
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-light text-dark" type="submit">Excluir</button>           
                    </form>                 
                    </td>               
                </tr>            
                @endforeach
                <tr> 
                    <th>{{'Gastos Totais'}}</th>
                    @if ($soma > $salarios)
                    <td class="bg-danger">{{$soma}}</td>
                    @else                 
                    <td>{{$soma}}</td>
                    @endif   
                    @if ($restante <= "0")
                    <th colspan="2" >{{'Restante'}}</th>
                    <td class="bg-danger">{{$restante}}</td> 
                    @else
                    <th colspan="2">{{'Restante'}}</th>                
                    <td>{{$restante}}<div class="btn-group">

                    <!--adicionar Economias-->
                    <form  action="{{route('gestao.store')}}" method="POST">
                    @csrf 
                    <input type="hidden" class="form-control " name="mes_id" value="{{$input_mes}}">
                   
                    <input type="hidden" class="form-control" name="economia" value="{{$restante}}">

                    <button type="submit" class="btn btn-primary btn-sm">Saved</button>                
                    </div>
                    </form></td>
                    @endif 
                </tr> 
                </table> 
            </div>
            <hr>
            @if ($input_mes != '')
            
            <!--adicionar Gastos-->
            <div class="row g-2">        
                <div class="col-md-1">                           
                    <form  action="{{route('gestao.store')}}" method="POST">
                    @csrf
                    <span>Gastos</span>
                    <input type="hidden" class="form-control" name="mes_id" value="{{$input_mes}}">
                </div>            
                <div class="col-md-3">                           
                    <input type="text" class="form-control"  placeholder="Gastos" name="gastos" >
                </div>
                <div class="col-md-2">                           
                    <input type="text" class="form-control" placeholder="Valores" name="valores" >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-">Add</button>                
                </div>    
                    </form>
            </div> 
            <hr>
            <!--adicionar Salario-->
            <div class="row g-2">
                <div class="col-md-1">                           
                    <form  action="{{route('gestao.store')}}" method="POST">
                    @csrf
                    <span>Salario</span>
                        <input type="hidden" class="form-control" name="mes_id" value="{{$input_mes}}">
                </div>                      
                <div class="col-md-2">                           
                    <input type="text" class="form-control" placeholder="Salario" name="salario" >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-">Add</button>                
                </div>    
                    </form>
            </div> 
            @endif      
        </div> 

        <div class="col-sm-4">
            <div class="col-md-12 bg-warning">
                @if ($economia <= '5000' )
                <div class="col-md-3">
                    <span class="text-danger"> Total Saved {{$economia}}</span>
                </div>     
                @else       
                <div class="col-md-3">
                    <span class="text-success">Total Saved {{$economia}}</span>
                </div>
                @endif 
                <div class="col-md-7">
                    <span >Falta {{$economia - '8000'}}</span>
                </div>
                <div class="col-md-7">
                     @foreach ( $gastos as $gestaogasto )
                     @if($gestaogasto->pago != '1')
                    <span class="text-danger">A Conta {{$gestaogasto->gastos}} não foi Paga</span>


                     @endif
                     @endforeach
                </div>     

            </div> 
        </div> 
    </div> 
</div>
@endsection
