$(document).ready(function () {
    // Función para consultar los detalles de un pedido
    $(document).on('click', '.view-order-btn', function () {
        const orderId = $(this).data('id');

        // Realizar una solicitud AJAX para obtener los detalles del pedido
        $.ajax({
            url: `/pedidos/${orderId}`, // Ruta para consultar el pedido
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    // Crear la lista de detalles del pedido
                    const detailsList = response.order.details.map(detail => `
                        <li>${detail.article_name} - Cantidad: ${detail.quantity}</li>
                    `).join('');

                    // Insertar los detalles en el modal
                    $('#order-details-list').html(detailsList);

                    // Mostrar el modal
                    $('#orderModal').modal('show');
                } else {
                    alert('Error al consultar el pedido.');
                }
            },
            error: function (error) {
                console.error('Error al consultar el pedido:', error);
                alert('Hubo un problema al consultar el pedido.');
            }
        });
    });

    // Función para eliminar un pedido
    $(document).on('click', '.delete-order-btn', function () {
        const orderId = $(this).data('id');

        if (confirm('¿Estás seguro de que deseas eliminar este pedido?')) {
            $.ajax({
                url: `/pedidos/${orderId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.success) {
                        alert('Pedido eliminado con éxito.');
                        $(`#order-row-${orderId}`).fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        alert('Error al eliminar el pedido.');
                    }
                },
                error: function (error) {
                    console.error('Error al eliminar el pedido:', error);
                    alert('Hubo un problema al eliminar el pedido.');
                }
            });
        }
    });
});
