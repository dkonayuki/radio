<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name') !!}
</div>
<div class="form-group">
    {!! Form::label('stream_url', 'Stream URL:') !!}
    {!! Form::text('stream_url') !!}
</div>
<div class="form-group">
    {!! Form::label('schedule_url', 'Schedule URL:') !!}
    {!! Form::text('schedule_url') !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description') !!}
</div>
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image') !!}
</div>
<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-info']) !!}
</div>
