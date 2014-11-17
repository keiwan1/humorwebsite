@extends('layouts.master')

@section('content')
		<h2 style="text-align: center">Sign in</h2>
		<div class="form-signin">

	{{ Form::open(array('action' => 'UserController@signin')) }}
		<p class="text-danger">{{Session::get('Signinnote')}}</p>
		<p><div class="input-group">{{ Form::text('name', Input::old('name'), array('placeholder'=>'Username or Email','class' => 'form-control')) }}<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span></div> </p>

		<p><div class="input-group">{{ Form::password('password', array('placeholder'=>'Password','class' => 'form-control')) }}<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span></div></p>
	</br>
	
		<p> {{ Form::submit('Log in', array('class' => 'btn btn-primary btn-lg')) }} </p>

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