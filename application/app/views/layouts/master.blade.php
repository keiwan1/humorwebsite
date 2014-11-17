<!DOCTYPE html>
<html>
<head>

    <?php $settings = Setting::first(); ?>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
   
    <title>{{ $settings->website_name }} - {{ $settings->website_description }}</title>
    
    
    {{HTML::style('application/assets/css/bootstrap.min.css')}}
    {{HTML::style('application/assets/css/style.css')}}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    
    <link rel="shortcut icon" href="{{ URL::to('/') . '/' . $settings->favicon }}" type="image/x-icon">


</head>
<body>	
						
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" title="gayyyyy">Logo</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{URL::to('/')}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-fire"></span> Popular <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">day</a></li>
                <li><a href="#">week</a></li>
                <li><a href="#">year</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-folder-open"></span> Category <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Pictures</a></li>
                <li><a href="#">Video</a></li>
                <li><a href="#">Nukta</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
           
                 


        
            <li style="background:#db3b3b;"><a style="color:white;" href="{{URL::to('upload')}}"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</a></li>
         @if(Auth::guest())
            

            <li><a href="{{URL::to('signin')}}">Log in</a></li>
            <li><a href="{{URL::to('signup')}}">Register</a></li>

         @else
            <?php $unseencomm = Auth::user()->unseenComments();
                  $unseencount = count($unseencomm); ?>
                @if($unseencount == 0)
                <li class="dropdown">
                  <a href="#" id="profiletoggledown" class="dropdown-toggle" data-toggle="dropdown">
                   <span style="font-size:16px" class="glyphicon glyphicon-bell"></span> notifications <span class="badge">{{$unseencount}}</span>
                     <ul class="dropdown-menu scrollable-menu" role="menu">
                @else
                    <li class="dropdown">
                  <a href="#" id="profiletoggledown" class="dropdown-toggle" data-toggle="dropdown">
                   <span class="glyphicon glyphicon-bell"></span> notifications <span class="badge badge-important">{{$unseencount}}</span>
                     <ul class="dropdown-menu scrollable-menu" role="menu">
                @endif

            @if($unseencomm != false && !$unseencomm->isEmpty())

                @foreach($unseencomm as $com)

                <li><a class="newcomment" data-id="{{$com->id}}" href="{{URL::to('media') . '/' .$com->media()->slug}}"><span class="glyphicon glyphicon-cog"></span>
                    {{$com->user()->username}} commented on your post</a></li>
                @endforeach
            @else
                <li><a><span class="glyphicon glyphicon-cog"></span> No new notifications</a></li>
            @endif
         
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" id="profiletoggledown" class="dropdown-toggle" data-toggle="dropdown">
               
               
                <div id="user-info"><img width="30px" height="30px" src="{{URL::to('/') . '/content/uploads/avatars/' . Auth::user()->comavatar}}" class="img-rounded" alt="Profile Pic">  @if(strlen(Auth::user()->username) > 8){{ substr(Auth::user()->username, 0, 8) . '...' }}@else{{ Auth::user()->username }}@endif <b class="caret"></b></div>
                
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('u') . '/' . Auth::user()->username}}"><span class="glyphicon glyphicon-user"></span> My profile</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('logout')}}"><span class="glyphicon glyphicon-off"></span> Log out</a></li>
              </ul>
            </li>

            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

<!-- Page Content -->
    <div class="container">
        @yield('userprofilebar')

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                @if(Session::get('Errornote') != '' || Session::get('note') != '' || Session::get('flash_message') != '')
                <div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Warning!</strong> {{Session::get('Errornote')}} {{ Session::get('note')}} {{Session::get('flash_message')}}
</div>
				@endif
				@yield('content')

                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div id="sidebar_container" class="col-md-4 ">
                @yield('sidebarinfo')
                
            </div>

        </div>
        <!-- /.row -->

        <hr>

 <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; boxoshi</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	{{HTML::script('application/assets/js/bootstrap.min.js')}}
	<script type="text/javascript">
		$('.gifplay-badge').bind('click', function() {
    		$(this).prev().attr({
    		    src: $(this).prev().attr('data-src') 
    		    , 'data-src': $(this).prev().attr('src') 
    		})
            $(this).fadeOut();
		});

        $('img').bind('click', function() {
            $(this).attr({
                src: $(this).attr('data-src') 
                , 'data-src': $(this).attr('src') 
            })
            $(this).next("span").toggle();
        });

          
     
        

       $(document).ready(function(){
            $('.newcomment').click(function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('href');

            
            $.post('../noticomment', {id: id, url: url}, function(data){
                window.location.href = url;
            });

            });
            });



		</script>

 @yield('scripts')
	
</body>
</html>