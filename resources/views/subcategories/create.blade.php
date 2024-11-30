@extends('layouts.app')

@section('content')
    <div  class="my-5">
        <form method="POST" action="{{ route('subcategory.store') }}">

            @csrf
            <div class="mb-3">
                <label for="nombreSubcategoria" class="form-label">Nombre de la Subcategoría</label>
                <input type="text" class="form-control" id="nombreSubcategoria" name="nombreSubcategoria" placeholder="">
                @if ($errors->has('nombreSubcategoria'))
                    <span class="text-danger">{{ $errors->first('nombreSubcategoria') }}</span>
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
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categories as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                    @endforeach
                </select>
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
