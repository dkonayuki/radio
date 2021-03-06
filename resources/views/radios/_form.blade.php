<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name') !!}
</div>
<div class="form-group">
    {!! Form::label('stream_url', 'Stream URL:') !!}
    {!! Form::text('stream_url') !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description') !!}
</div>
<div class="form-group">
    {!! Form::label('logo_url', 'Image:') !!}
    {!! Form::file('logo_url') !!}
</div>
<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-info']) !!}
</div>
