@extends('core::page.pengguna')
@section('inner-title', __('core::general.create.title', ['attribute' => $title]) . " - ")
@section('mSSO', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
@endsection

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            'use strict'
            $("#ajax-sso").select2({
                ajax: {
                    url: 'https://sso.samarindakota.go.id/api/sso/findUser',
                    dataType: 'json',
                    delay: 250,
                    type: "POST",
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                placeholder: 'Pilih Pengguna SSO',
                minimumInputLength: 2
            });
        });
    </script>
@endsection

@section('content')
    <section class="box-typical">

        {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('core::general.create.title', ['attribute' => $title]),
                'subjudul' => __('core::general.subtitle.create'),
                'kembali' => route("$prefix.index")
            ])

            <div class="card">


                <div class="padding-panel" style="padding-bottom: 0;">
                    <div class="alert alert-warning alert-fill alert-border-left" role="alert">
                        <strong>PERHATIAN!</strong> <br/>
                        <b>(1)</b> Pastikan calon Operator yang ingin ditambahkan telah terdaftar dalam database <b>SSO Samarinda</b>.<br/>
                        <b>(2)</b> Bila belum terdaftar, silahkan klik link berikut: <a href="https://sso.samarindakota.go.id:49001/register" target="_blank">https://sso.samarindakota.go.id:49001</a> untuk melakukan pendaftaran terlebih dahulu.
                    </div>
                </div>

                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>
            
        {!! Form::close() !!}

    </section>
@endsection