@extends('layouts.master')
<?php $user_avatar = URL::to('/') . '/content/uploads/avatars/' . $user->avatar; ?>
@section('userprofilebar')
<section class="profile-header" style="">
       
        <div class="avatar-container">
                <img src="{{$user_avatar}}" class="img-rounded" alt="{{$user->username}} Profile Pic">         
        
        <div class="info">
            <h3>{{$user->username}}</h3>
            <h5><span style="color:gold;" class="glyphicon glyphicon-star"></span> 500 points</h5>
    	</div>

    </div>
</section>

<div class="section-nav">
    <div class="width-limit">
       <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a href="/u/{{$user->username}}">Posts</a></li>
            <li><a class="" href="/u/rambosser/posts">comments</a></li>
            <li><a class="" href="/u/rambosser/likes">UPVOTES</a></li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>

@stop

@section('content')
@if (count($posts) != 0)
	@foreach($posts as $item)
	
		
	@include('media.single')

	@endforeach
@else
<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-minus-sign"></span> No uploads yet..</div>
@endif


@stop