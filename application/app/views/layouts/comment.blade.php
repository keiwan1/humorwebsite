@if(Auth::guest())

<div class="alert alert-info" role="alert">
  To post a comment you have to <a href="../signin" class="alert-link">Login</a>
  If you don't have an account? <a href="../signup" class="alert-link">Register here</a>
</div>

@else


<div class="form-group">
    
	{{ Form::open(array('url' => '/comments')) }}

</br>

    <div class="errormessage-form">{{$errors->first('comment')}}</div> 

<div id="commentform" class="media"><h4 class="media-heading">Your comment</h4>
  <a class="pull-left" >
    <img width="65" height="72" class="media-object" src="{{URL::to('/') . '/content/uploads/avatars/' . Auth::user()->avatar}}" alt="{{Auth::user()->username . ' profile pic'}}">
  </a>
  <div class="media-body">
    
    {{ Form::textarea('comment', null, array('size' => '30x3','id' => 'commentfield', 'class' => 'form-control')) }} 
    {{ Form::hidden('media_id', "$media->id" )  }} 
    {{ Form::hidden('parent_id', "0", array('id' => 'parentid'))  }} 
  </br>
	{{ Form::submit('Place comment', array('class' => 'btn btn-danger btn-md')) }} 
		</div>

			{{ Form::close() }}
</div>
</div>

@endif

<hr>

<ul class="media-list">
@foreach($commentlist as $comment)

<li class="media" data-id="{{$comment->id}}">
    <a class="pull-left" href="../u/{{$comment->user()->username}}">
      <img class="media-object" src="../content/uploads/avatars/{{$comment->user()->comavatar}}" alt="{{$comment->user()->username}} profile pic">
    </a>
    <div class="media-body">
      <h3 id="usernamefield" class="media-heading">{{$comment->user()->username}}</h3>
      {{$comment->comment}}</br>
      <a class="replylink">Reply</a>
      
        @foreach($comment->children() as $reply)
              <div class="media" data-id="{{$comment->id}}">
                <a class="pull-left" href="../u/{{$reply->user()->username}}">
                  <img height="35" width="35" class="media-object" src="../content/uploads/avatars/{{$reply->user()->comavatar}}" alt="{{$reply->user()->username}} profile pic">
                </a>
                <div class="media-body">
                  <h4 id="usernamefield" class="media-heading">{{$reply->user()->username}}</h4>
                    {{$reply->comment}}</br>
                    <a class="replylink">Reply</a>
                </div>
              </div>

        @endforeach
     
    </div>
</li>
  

@endforeach
</ul>
