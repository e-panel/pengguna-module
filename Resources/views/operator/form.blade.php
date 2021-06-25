<div class="box-typical-body padding-panel">
    <div class="row">
        <div class="col-md-8">

            <fieldset class="form-group {{ $errors->has('nama')?'form-group-error':'' }}">
                <label for="nama" class="form-label">{{ __('pengguna::form.operator.name.label') }} <span class="color-red">*</span></label>
                <div class="form-control-wrapper">
                    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => __('pengguna::form.operator.name.placeholder')]) !!}
                    {!! $errors->first('nama', '<span class="text-muted"><small>:message</small></span>') !!}
                </div>
            </fieldset>
           
            <div class="row">
            	<div class="col-md-6">
            		<fieldset class="form-group {{ $errors->has('username')?'form-group-error':'' }}">
                        <label for="username" class="form-label">{{ __('pengguna::form.operator.email.label') }} <span class="color-red">*</span></label>
    		            <div class="form-control-wrapper">
    		                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('pengguna::form.operator.email.placeholder')]) !!}
                            {!! $errors->first('username', '<span class="text-muted"><small>:message</small></span>') !!}
    		            </div>
    		        </fieldset>
            	</div>
            	<div class="col-md-6">
            		<fieldset class="form-group {{ $errors->has('password')?'form-group-error':'' }}">
                        <label for="password" class="form-label">
                            {{ __('pengguna::form.operator.password.label') }} 
                            @if(!isset($edit))
                                <span class="color-red">*</span>
                            @endif
                        </label>
    		            <div class="form-control-wrapper">
    		                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('pengguna::form.operator.password.placeholder')]) !!}
                            {!! $errors->first('password', '<span class="text-muted"><small>:message</small></span>') !!}
    		            </div>
    		        </fieldset>
            	</div>
            </div>

            <fieldset class="form-group {{ $errors->first('role_id', 'form-group-error') }}">
                <label for="role_id" class="form-label">
                    {{ __('pengguna::form.sso.role.label') }}
                    <span class="color-red">*</span>
                </label>
                <div class="form-control-wrapper">
                    <select class="form-control select2" name="role_id">
                        @foreach(\Modules\Pengguna\Entities\Role::all() as $temp)
                            <option value="{{ $temp->id }}"
                                @if(isset($edit))
                                    @if($edit->role_id == $temp->id)
                                        selected="selected" 
                                    @endif
                                @endif
                            >{{ $temp->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('role_id', '<span class="text-muted"><small>:message</small></span>') !!}
                </div>
            </fieldset>

        </div>
        <div class="col-md-4">

            <fieldset class="form-group {{ $errors->first('avatar', 'form-group-error') }}">
                <label for="avatar" class="form-label">{{ __('pengguna::form.operator.avatar.label') }}</label>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                        @if(!isset($edit))
                            <img data-src="holder.js/500x500/auto" alt="...">
                        @else
                            <img src="{{ viewImg($edit->avatar) }}" alt="{{ $edit->judul }}">
                        @endif
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                    <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new">{{ __('pengguna::form.operator.avatar.select') }}</span>
                            <span class="fileinput-exists">{{ __('pengguna::form.operator.avatar.change') }}</span>
                            {!! Form::file('avatar', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        </span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ __('pengguna::form.operator.avatar.remove') }}</a>
                    </div>
                    {!! $errors->first('avatar', '<span class="text-muted"><small>:message</small></span>') !!}
                </div>
            </fieldset>

        </div>
    </div>
</div>
        
