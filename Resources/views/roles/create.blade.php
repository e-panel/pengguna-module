@extends('core::page.pengguna')
@section('inner-title', __('core::general.create.title', ['attribute' => $title]) . " - ")
@section('mRoles', 'opened')

@section('content')
    <section class="box-typical">

        {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('core::general.create.title', ['attribute' => $title]),
                'subjudul' => __('core::general.subtitle.create'),
                'kembali' => route("$prefix.index")
            ])

            <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>
            
        {!! Form::close() !!}

    </section>
@endsection