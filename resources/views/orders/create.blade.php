@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container">
        <!-- Input oculto para el ID del usuario autenticado -->
        <input id="userLoggediD" type="hidden" value="{{ auth()->user()->id }}">

        <!-- Contenedor donde se cargarán las tarjetas de artículos -->
        <div id="articles-container" class="row"></div>
    </div>
@endsection
@section('js')
    <!-- Metaetiqueta para el token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts necesarios -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="application/javascript"></script>
    <script src="{{ asset('js/articlesOrder.js') }}"></script>
@endsection
