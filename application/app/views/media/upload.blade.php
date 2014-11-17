@extends('layouts.master')



@section('content')
		<h2 style="text-align: center">Upload Media</h2>
		<h3> </h3>
<div class="form-group">
    
	{{ Form::open(array('url' => '/media', 'files' => true)) }}

		

        <div class="btn-group-lg" data-toggle="buttons" style="text-align: center;">
  <label class="btn btn-primary active">
    {{ Form::radio('radiooption', 'pic', true, array('id'=>'pictureradio'))}}<span class="glyphicon glyphicon-picture"></span> Add pic
</label>
<label class="btn btn-primary">
    {{ Form::radio('radiooption', 'vid', '', array('id'=>'videoradio'))}}<span class="glyphicon glyphicon-film"></span> Add video
</label>
<label class="btn btn-primary">
    {{ Form::radio('radiooption', 'nukta', '', array('id'=>'nuktaradio'))}}<span class="glyphicon glyphicon-list-alt"></span> Add nukta
</label></div>


	</br></br>

    <p class="text-danger">{{$errors->first('title')}}</p> 
	<p>  {{ Form::text('title', '', array('placeholder'=>'Title','class' => 'form-control')) }} </p>
		
		
		<div id="pic_upload" style="padding-left:100px; background:#f1f1f1; padding:15px; margin-top:15px; margin-bottom:15px;">
			 <span class="glyphicon glyphicon-picture" style="float:left; font-size:50px;"> </span>
  <div class="col-lg-6">{{ Form::file('file', array('id' => 'fileup', 'class' => 'form-control')) }}</div></br>
             <p> {{ Form::text('pic_url', '', array('placeholder'=>'Picture URL','id' => 'pic_url_textbox', 'class' => 'form-control')) }} </p>
		</div>
		
		<div id="vid_upload" style="display: none; padding-left:100px; background:#f1f1f1; padding:15px; margin-top:15px; margin-bottom:15px;">
				<p> {{ Form::text('vid_url', '', array('placeholder'=>'Video URL','class' => 'form-control')) }} </p>
                <span class="help-block">please insert a normal youtube or vine link</span>
		</div>

		<div id="nukta_upload" style="display:none; padding-left:100px; background:#f1f1f1; padding:15px; margin-top:15px; margin-bottom:15px;">
				<p>{{ Form::textarea('nukta', '',array('placeholder'=>'Nukta here','class' => 'form-control')) }} </p>
                <span class="help-block">write a normal nukta here</span>
		</div>
				
				<p> {{ Form::submit('Upload now', array('class' => 'btn btn-primary btn-lg')) }} </p>
		
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

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $('input[type=radio][name=radiooption]').on('change', function(){
            $('.form-group').find('input:text, textarea, file').val('');
            switch($(this).val()){
                case 'pic' :
                    $('#vid_upload').hide();
                    $('#nukta_upload').hide();
                    $('#pic_upload').show();
                    break;
                case 'vid' : 
                    $('#vid_upload').show();
                    $('#nukta_upload').hide();
                    $('#pic_upload').hide();
                    break;
                case 'nukta' :
                    $('#vid_upload').hide();
                    $('#nukta_upload').show();
                    $('#pic_upload').hide();
                    break;
            }  
            $('#fileup').removeAttr('disabled'); 
            $("#fileup").val('');         
        });
    });

        $('#pic_url_textbox').keyup(function (){
            if($(this).val() != ''){
                $("#fileup").val('');
                $('#fileup').attr('disabled', 'true');
            } else {
                $('#fileup').removeAttr('disabled');
            }
        });
</script>

@stop