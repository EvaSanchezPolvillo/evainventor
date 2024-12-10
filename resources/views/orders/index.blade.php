@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="container">
    <h2>Lista de Pedidos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr id="order-row-{{ $order->id }}">
                <td>{{ $order->id }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <!-- Botón para consultar el pedido -->
                    <button class="btn btn-info btn-sm view-order-btn" data-id="{{ $order->id }}">Consultar</button>

                    <!-- Botón para eliminar el pedido -->
                    <button class="btn btn-danger btn-sm delete-order-btn" data-id="{{ $order->id }}">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para mostrar los detalles del pedido -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Detalles del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargarán dinámicamente los detalles -->
                <ul id="order-details-list"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="application/javascript"></script>
    <script src="{{ asset('js/order.js') }}"></script>
@endsection
