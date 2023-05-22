@extends('layouts.app')

@section('content')
<div class="container m-5 p-0">
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-4">                                 
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
                        <div class="col-md-2">
                           
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
            <div class="container mt- justify-content-center" >                                
                <table class="table table-bordered">
                <tr>
                    <th>{{'Spending'}}</th>
                    <th colspan="2">{{'Values'}}</th>
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
                    <td><button type="submit" class="btn btn-danger btn-sm" disabled>Saved</button></td>
                    <th>{{'Remaining'}}</th>
                    <td class="bg-danger">{{$restante}}</td> 
                    @else                    
                    <td> <!--adicionar Economias-->
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
                    <th>{{'Restante'}}</th>                
                    <td>{{$restante}}</td>
                    @endif 
                </tr> 
                </table> 
            </div>
</div>
@endsection
