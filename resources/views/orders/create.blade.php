@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container">

        <input id="userLoggediD" type="hidden" value="{{auth()->user()->id}}">
        <div id="articles-container" class="row"></div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="application/javascript"></script>
    <script src="{{ asset('storage/js/articlesOrder.js') }}"></script>
@endsection
