@extends('layouts.master')

@section('content')
	<h2>{{$media->title}}</h2>

			<span class="glyphicon glyphicon-user"></span> {{$media->user()->username}}
			views:{{$media->views}}
		</br><hr>

@if($media->pic ==1)
	
		
	@if(substr($media->pic_url, -3, 3) == 'gif')
			
			
		<img style="margin:0 auto;" class="img-responsive" class="single-media-gif" alt="{{$media->title}}" data-src="{{ URL::to('/') . '/content/uploads/images/' . $media->pic_url }}" src="{{ URL::to('/') . '/content/uploads/images/' . substr_replace($media->pic_url, '-animation.gif', -4) }}"/>
		<span style="display:none;" class="gifplay-badge">GIF</span>	
	@else
				
			<img style="margin:0 auto;" class="img-responsive" alt="{{$media->title}}" src="{{ URL::to('/') . '/content/uploads/images/' . $media->pic_url }}" />
				
	@endif


@elseif($media->vid ==1)

	
			<!-- YOUTUBE VIDEO -->
					@if (strpos($media->vid_url, 'youtube') > 0 || strpos($media->vid_url, 'youtu.be') > 0)
				 
			<div class="embed-responsive embed-responsive-16by9" style="margin: 0 auto;text-align:center;"><iframe class="embed-responsive-item" title="YouTube video player" class="youtube-player" type="text/html" src="http://www.youtube.com/embed/{{Helper::getYoutubeid($media->vid_url)}}?theme=light&rel=0"
			allowFullScreen></iframe></div>
				   
				    @endif 

				
@else

		<div class="nukta_text" style="direction:rtl;"> 
			<blockquote class="blockquote-reverse">
				<p>{{$media->nukta_text}} </p>
			</blockquote>
			</div>
		

@endif
<hr class="commentareadivider">

@include('layouts.comment')
	
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

@section('scripts')

<script type="text/javascript">


$(".replylink").bind("click" ,function(){
     
     var text = $(this).parent().parent().attr('data-id');
   
	$('html, body').animate({
	       scrollTop: $(".commentareadivider").offset().bottom
	   }, 200);
      
	$("textarea#commentfield").focus();
	$("#parentid").val(text);
	
   

   });

		</script>

@stop