@extends('layouts.app')

@section('content')
    <div  class="my-5">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombreCategoria" class="form-label">Nombre de la categoría</label>
                <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="">
                @if ($errors->has('nombreCategoria'))
                    <span class="text-danger">{{ $errors->first('nombreCategoria') }}</span>
                @endif
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="available" name="available">
                <label class="form-check-label" for="flexCheckDefault">
                    Disponible
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="visible" name="visible">
                <label class="form-check-label" for="flexCheckChecked">
                    Visible
                </label>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary text-black">Guardar</button>
        </form>
    </div>
@endsection

