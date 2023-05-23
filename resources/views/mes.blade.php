@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
            <div class='col-sm-4'>
                <div class="col-md-12  alert alert-success  ">
                    <div class="row g-2">
                        <div class="col-md-6">            
                            @if ($economia <= '8000' )                
                                <span class="text-dark">
                            @else 
                                <span class="text-success">
                            @endif 
                                    <strong >{{'Total Saved'}}</strong>: € {{$economia}}</span>
                        </div> 
                        <div class="col-md-2">
                        </div>                        
                        <div class="col-md-4">
                            @if ($economia >= '8000')
                                <span class="text-success" >
                            @else
                                <span class="text-dark" >
                            @endif
                            @if ($economia <= '8000')
                                € {{$economia - '8000'}} <strong>{{'Left to hit the goal'}}</strong></span>
                            @else
                                € {{$economia - '8000'}} <strong>{{'Passed of the goal'}}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>  
                <!--Aviso contas nao Pagas-->      
                <div class="col-md-12  alert alert-warning  ">
                    <div class="row g-2">                
                        <div class="col-md-12">
                            @foreach ( $avisos as $aviso )
                            @if($aviso->pago == NULL)                                        
                                <span class="text-danger"><strong>{{'Month'}}  {{$aviso->mes->mes}}: {{$aviso->gastos}} {{'was not paid'}}</strong></span> 
                            <br>
                            @endif
                            @endforeach                     
                        </div>
                            @if(isset($rest))    
                        <div class="col-md-12">
                            @if ($rest == '0')
                                <span class="text-success">   
                            @else
                                <span class="text-danger"> 
                            @endif
                                {{'Amount to be Paid in the Month'}} {{date('M') }}:<strong> € {{$rest}}</strong></span>
                        </div>
                            @endif
                    </div>
                </div> 
            </div>
        <div class="col-sm-8">
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-3">                                 
                            <form method="GET" action="{{ route('gestao.index') }}">
                            <select class="form-select" name="mes" >
                            <option data-default disabled selected >Select the Month</option>
                            @foreach ( $mes as $x )
                            <option value="{{$x->id}}" {{$x->id  == $input_mes ? 'selected' : ''}}>{{$x->mes}}</option>  
                            @endforeach
                            </select>                                    
                        </div>                   
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mt-">Submit</button>
                            <a href='{{ route('gestao.index') }}' class="btn btn-primary">Clear</a>                                                        
                        </div>    
                           </form>
                        <div class="col-md-3">
                           
                           </div>
                           <!--adicionar Gastos-->
                        <div class="col-md-1">
                         @if ($input_mes != '')
                            <form  action="{{route('gestao.store')}}" method="POST">
                            @csrf                    
                            <input type="hidden" class="form-control" name="mes_id" value="{{$input_mes}}">
                            <button type="submit" class="btn btn-primary mt-">Add Spent</button>
                            </form>                         
                        </div>
                         <!--adicionar Salario-->
                        <div class="col-md-2">
                            <form  action="{{route('gestao.store')}}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="mes_id" value="{{$input_mes}}">                                                   
                            <input type="text" class="form-control" placeholder="Salary" name="salario" >
                            </div> 
                            <div class="col-md-1">                        
                            <button type="submit" class="btn btn-primary mt-">Add</button>
                            </form>
                        </div> 
                        @endif
                </div> 
            </div> 
            <hr>
            <div class="row justify-content-center " >                                
                <table class="table table-bordered table-responsive  ">
                <tr>
                    <th>{{'Spending'}}</th>
                    <th>{{'Values'}}</th>
                    <th>{{'Paid'}}</th>
                    <th>{{'Salary'}}</th>
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
                    <button class="btn btn-outline-light text-dark" type="submit">Edit</button> 
                    </form>
                    </td>
                    <td >
                    <form  action={{route('gestao.destroy', ['gestao' => $gestaogasto->id])}} method='POST'>
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-light text-dark" type="submit">Delete</button>           
                    </form>                 
                    </td>               
                </tr>            
                @endforeach
                <tr> 
                    <th>{{'Total Expenses'}}</th>
                    @if ($soma > $salarios)
                    <td class="bg-danger">{{$soma}}</td>
                    @else                 
                    <td>{{$soma}}</td>
                    @endif   
                    @if ($restante <= "0")
                    <th>{{'Remaining'}}</th>
                    <td><button type="submit" class="btn btn-danger btn-sm" disabled>Saved</button></td>                    
                    <td class="bg-danger">{{$restante}}</td> 
                    @else
                    <th>{{'Restante'}}</th>                     
                    <td class="justify-content-center" > 
                    <!--adicionar Economias-->
                    <form  action="{{route('gestao.store')}}" method="POST">
                    @csrf 
                    <input type="hidden" class="form-control " name="mes_id" value="{{$input_mes}}">
                   
                    <input type="hidden" class="form-control" name="economia" value="{{$restante}}">
                    @if ($restante == ($salarios - $soma))
                    <button type="submit" class="btn btn-primary btn-sm">Saved</button>                
                    @else
                    <button type="submit" class="btn btn-danger btn-sm" disabled>Saved</button>
                    @endif
                    </form></td>                                   
                    <td>{{$restante}}</td>
                    @endif 
                </tr> 
                </table> 
            </div>
        </div>    
        </div>   
    </div>        
</div>

@endsection
