
  			<?php $user_url = URL::to('u') . '/' . $item->user()->username;
  				  $username = $item->user()->username;
  				  
  			?>
 	<div id="full_item">
            <h2 class="item-title"><a href="{{ URL::to('media') . '/' . $item->slug; }}" alt="{{ $item->title }}">{{{ stripslashes($item->title) }}}</a></h2>

            <div class="item-details">
				<p class="details" ><span class="glyphicon glyphicon-user"></span> <a style="color:blue;" href="{{ $user_url }}">{{ $username}}</a> <span class="glyphicon glyphicon-comment"></span> comments: {{  $item->totalComments() }}
				<span class="glyphicon glyphicon-eye-open"> {{ $item->views }}</p>
			</div>
            <hr>
        @if($item->pic == 1)
		
			@if(substr($item->pic_url, -3, 3) == 'gif')
			
			<div id="gifdivhome">
			<img style="margin:0 auto;" class="img-responsive" class="single-media-gif" alt="{{$item->title}}" src="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" data-src="{{ URL::to('/') . '/content/uploads/images/' . substr_replace($item->pic_url, '-animation.gif', -4) }}"/>
			<span class="gifplay-badge">GIF</span>
		</div>
			@else
				<div class="imghome" style="text-align:center;">
				<a href="{{ URL::to('media') . '/' . $item->slug; }}">
					<img style="display:inline;" class="img-responsive" alt="{{$item->title}}" src="{{ URL::to('/') . '/content/uploads/images/' . $item->pic_url }}" />
				</a></div>
				
			@endif
		@elseif($item->vid == 1)
			@if (strpos($item->vid_url, 'youtube') > 0 || strpos($item->vid_url, 'youtu.be') > 0)
			       
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" title="YouTube video player" class="youtube-player" type="text/html" src="http://www.youtube.com/embed/{{Helper::getYoutubeid($item->vid_url)}}?theme=light&rel=0" allowFullScreen></iframe>
				</div>
					  
							   
			@endif 
		@else

		<div class="nukta_text" style="direction:rtl;"> 
			<blockquote class="blockquote-reverse">
				<p>{{$item->nukta_text}} </p>
			</blockquote>
			</div>

		@endif
	</div>
        <hr>