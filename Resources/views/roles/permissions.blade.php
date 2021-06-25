@extends('core::page.pengguna')
@section('inner-title', __('pengguna::general.manage') . " - ")
@section('mRoles', 'opened')

@section('css')
    <style type="text/css">
        .checkbox-detailed input+label {
            height: 40px!important;
        }
    </style>
@endsection

@section('content')
    <section class="box-typical">

        {!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'method' => 'put']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('pengguna::general.manage', ['title' => $title]),
                'subjudul' => __('pengguna::general.roles.subtitle.manage'),
                'kembali' => route("$prefix.index")
            ])
        
            <div class="card">

                @php
                    $permissions = $edit->permissions;
                    if(!empty($edit->permissions)):
                        $permissions = json_decode($permissions, true);
                    endif;
                @endphp

                <div class="box-typical-body padding-panel">
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Permissions <span class="color-red">*</span></label>
                        <div class="col-sm-10">
                            @foreach(\Module::all() as $i => $temp)
                                <div class="checkbox-detailed">
                                    <input type="checkbox" name="permissions[]" id="perm-{{ $i }}" value="{{ $temp }}"
                                        @if(is_array($permissions) && in_array($temp, $permissions)) 
                                            checked="checked"
                                        @endif
                                    >
                                    <label for="perm-{{ $i }}">
                                        <span class="checkbox-detailed-tbl">
                                            <span class="checkbox-detailed-cell">
                                                <span class="checkbox-detailed-title">{{ $temp }}</span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @include('core::layouts.components.submit')
            </div>

            {!! Form::hidden('name', $edit->name) !!}
            {!! Form::hidden('purpose', 'permissions') !!}
            
        {!! Form::close() !!}

    </section>
@endsection