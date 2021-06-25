@extends('core::page.pengguna')
@section('inner-title', __('core::general.create.title', ['attribute' => $title]) . " - ")
@section('mOperator', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
@endsection

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
@endsection

@section('content')
    <section class="box-typical">

        {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off', 'files' => true]) !!}

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