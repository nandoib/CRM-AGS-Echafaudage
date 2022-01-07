@extends('layouts.layout')

@section('title')
    stats
@endsection

@section('content')  

<form class="offset-3" action="{{route('stats')}}" method="POST">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-bordered">
                

                <div class="form-group">
                    <label>Entre le </label>
                    <input type="date" class="form-control" name="datedepart">
                </div>
                
                <div class="form-group">
                    <label>et le  </label>
                    <input type="date" class="form-control" name="datefin">
                </div>
            
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary pull-right save">
        Enregistrer
    </button>
</form> 

@endsection