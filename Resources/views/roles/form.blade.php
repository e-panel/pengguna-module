<div class="box-typical-body padding-panel">

    <fieldset class="form-group {{ $errors->has('name')?'form-group-error':'' }}">
        <label class="form-label" for="name">
            {{ __('pengguna::form.roles.name.label') }} <span class="text-danger">*</span>
        </label>
        <div class="form-control-wrapper">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('pengguna::form.roles.name.placeholder')]) !!}
            {!! $errors->first('name', '<span class="text-muted"><small>:message</small></span>') !!}
        </div>
    </fieldset>

</div>
        
