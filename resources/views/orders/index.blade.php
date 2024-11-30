@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table id="ordersTable" class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th data-column="id">
                            Referencia
                        </th>
                        <th data-column="status">
                            Estado
                        </th>
                        <th data-column="create_at">
                            Fecha
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($orders)

                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @if ($order->status == 1)
                                        Solicitado
                                    @elseif ($order->status == 2)
                                        Aceptado
                                    @elseif ($order->status == 3)
                                        Denegado
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('storage/js/orders.js') }}"></script>
@endsection
