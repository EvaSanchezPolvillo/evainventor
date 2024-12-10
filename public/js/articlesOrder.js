$(document).ready(function () {
    // URL para obtener los artículos desde la API
    const apiUrl = "/api/articles";

    // Contenedor donde se agregarán las tarjetas
    const $articlesContainer = $('#articles-container');

    // Cargar los artículos al iniciar
    function loadArticles() {
        $.ajax({
            url: apiUrl,
            method: 'GET',
            success: function (response) {
                if (response.articles) {
                    renderArticles(response.articles);
                } else {
                    console.error('Formato inesperado de respuesta:', response);
                }
            },
            error: function (error) {
                console.error('Error al cargar los artículos:', error);
            }
        });
    }

    // Renderizar tarjetas de artículos
    function renderArticles(articles) {
        $articlesContainer.empty();

        articles.forEach(article => {
            const card = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="/storage/${article.image}" class="card-img-top" alt="${article.name}">
                        <div class="card-body">
                            <h5 class="card-title">${article.name}</h5>
                            <p class="card-text">Categoría: ${article.category}</p>
                            <p class="card-text">Subcategoría: ${article.subcategory}</p>
                            <p class="card-text">Stock: ${article.stock}</p>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-outline-secondary btn-sm decrement-btn" data-id="${article.id}" data-stock="${article.stock}">-</button>
                                <input type="number" class="form-control mx-2 text-center quantity-input" data-id="${article.id}" data-stock="${article.stock}" value="0" min="0" style="width: 60px;">
                                <button class="btn btn-outline-secondary btn-sm increment-btn" data-id="${article.id}" data-stock="${article.stock}">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $articlesContainer.append(card);
        });

        const orderButton = `
            <div class="mt-4 text-end">
                <button id="realizar-pedido-btn" class="btn btn-success">Realizar Pedido</button>
            </div>
        `;
        $articlesContainer.append(orderButton);

        attachEvents();
        $('#realizar-pedido-btn').click(realizarPedido);
    }

    function attachEvents() {
        $('.increment-btn').click(function () {
            const id = $(this).data('id');
            const $input = $(`.quantity-input[data-id="${id}"]`);
            const stock = parseInt($input.data('stock'));
            let quantity = parseInt($input.val());

            if (quantity + 1 > stock) {
                alert(`No puedes pedir más del stock disponible (${stock}).`);
                $input.val(stock);
            } else {
                $input.val(quantity + 1);
            }
        });

        $('.decrement-btn').click(function () {
            const id = $(this).data('id');
            const $input = $(`.quantity-input[data-id="${id}"]`);
            let quantity = parseInt($input.val());

            if (quantity - 1 < 0) {
                alert('La cantidad no puede ser menor a 0.');
                $input.val(0);
            } else {
                $input.val(quantity - 1);
            }
        });

        $('.quantity-input').change(function () {
            const stock = parseInt($(this).data('stock'));
            let quantity = parseInt($(this).val());

            if (quantity > stock) {
                alert(`No puedes pedir más del stock disponible (${stock}).`);
                $(this).val(stock);
            } else if (quantity < 0 || isNaN(quantity)) {
                alert('La cantidad no puede ser menor a 0.');
                $(this).val(0);
            }
        });
    }

    function realizarPedido() {
        const orderItems = [];
        $('.quantity-input').each(function () {
            const quantity = parseInt($(this).val());
            if (quantity > 0) {
                orderItems.push({
                    article_id: $(this).data('id'),
                    quantity: quantity,
                });
            }
        });

        if (orderItems.length === 0) {
            alert('No has seleccionado ningún artículo.');
            return;
        }

        const userId = $('#userLoggediD').val();

        if (!userId) {
            alert('Error: No se pudo obtener el ID del usuario.');
            return;
        }

        const requestData = {
            idUsuario: userId,
            orderDetail: orderItems,
        };

        $.ajax({
            url: "/api/saveOrderDetail",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(requestData),
            success: function (response) {
                if (response.success) {
                    alert(`Pedido realizado con éxito. ID del pedido: ${response.orderId}`);
                    loadArticles();
                } else {
                    alert('Hubo un problema al realizar el pedido.');
                    console.error(response.error);
                }
            },
            error: function (error) {
                console.error("Error al realizar el pedido:", error);
                alert("Hubo un problema al realizar el pedido.");
            }
        });
    }

    loadArticles();
});
