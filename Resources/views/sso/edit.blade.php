@extends('core::page.pengguna')
@section('inner-title', __('core::general.edit.title', ['attribute' => $title]) . " - ")
@section('mSSO', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
@endsection
@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
@endsection

@section('content')
    <section class="box-typical">

        {!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'method' => 'put']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('core::general.edit.title', ['attribute' => $title]),
                'subjudul' => __('core::general.subtitle.edit'),
                'kembali' => route("$prefix.index")
            ])
        
            <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>
            
        {!! Form::close() !!}

    </section>
@stop