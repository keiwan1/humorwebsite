@extends('layouts.master')



@section('content')
		<h2 style="text-align: center">Register an account</h2>
		<div class="form-signin">

	{{ Form::open(array('action' => 'UserController@signup')) }}

		<p class="text-danger">{{$errors->first('name')}} 
		{{Session::get('usernote')}}</p>
		<p> <div class="input-group">{{ Form::text('name', '', array('placeholder'=>'Username','class' => 'form-control')) }}<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span></div> </p>
		<p class="text-danger">{{$errors->first('email')}} </p>
		<p><div class="input-group"> {{ Form::text('email', '', array('placeholder'=>'Email','class' => 'form-control')) }} <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span></div> </p>
		<p class="text-danger">{{$errors->first('password')}} 
		{{Session::get('passwnote')}}</p>
		<p> <div class="input-group">{{ Form::password('password', array('placeholder'=>'Password','class' => 'form-control')) }}  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span></div> </p>
	
		<p> {{ Form::submit('Register now', array('class' => 'btn btn-primary btn-lg')) }} </p>

	{{ Form::close() }}
</div>
@stop

@section('sidebarinfo')

<!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                

@stop