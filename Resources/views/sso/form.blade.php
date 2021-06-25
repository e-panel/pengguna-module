<div class="box-typical-body padding-panel">
    <div class="row">
        <div class="col-md-12">
            @isset($edit)
                <fieldset class="form-group">
                    <label for="nama" class="form-label">{{ __('pengguna::form.operator.name.label') }} <span class="color-red">*</span></label>
                    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => __('pengguna::form.operator.name.placeholder'), 'readonly']) !!}
                </fieldset>
                <div class="row">
                	<div class="col-md-6">
                		<fieldset class="form-group">
                            <label for="username" class="form-label">{{ __('pengguna::form.operator.email.label') }} <span class="color-red">*</span></label>
                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('pengguna::form.operator.email.placeholder'), 'readonly']) !!}
        		        </fieldset>
                	</div>
                	<div class="col-md-6">
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
                </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                        <fieldset class="form-group {{ $errors->has('pengguna')?'form-group-error':'' }}">
                            <label for="pengguna" class="form-label">{{ __('pengguna::form.sso.pegawai.label') }} <span class="color-red">*</span></label>
                            <div class="form-control-wrapper">
                                <select id="ajax-sso" class="form-control" name="pengguna"></select>
                                {!! $errors->first('pengguna', '<span class="text-muted"><small>:message</small></span>') !!}
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
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
                </div>
            @endisset
        </div>
    </div>
</div>