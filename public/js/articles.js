document.addEventListener('DOMContentLoaded', function () {
    const articleForm = document.getElementById('articleForm');

    articleForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        // Crear un objeto FormData para enviar los datos
        const formData = new FormData(articleForm);

        // Enviar la solicitud AJAX
        fetch(storeArticleUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(async (response) => {
                if (response.ok) {
                    return response.json();
                } else if (response.status === 422) {
                    const data = await response.json();
                    throw { validationErrors: data.errors };
                } else {
                    throw new Error('Error inesperado en el servidor.');
                }
            })
            .then(() => {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'El artículo se ha creado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                });

                // Limpiar el formulario
                articleForm.reset();
            })
            .catch((error) => {
                if (error.validationErrors) {
                    document.querySelectorAll('.text-danger').forEach((el) => (el.textContent = ''));

                    for (const field in error.validationErrors) {
                        const errorElement = document.getElementById(`${field}Error`);
                        if (errorElement) {
                            errorElement.textContent = error.validationErrors[field][0];
                        }
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al procesar tu solicitud.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                    });
                }
            });
    });
});



document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('categoria');
    const subcategorySelect = document.getElementById('subcategoria');

    categorySelect.addEventListener('change', function () {
        const categoryId = this.value;

        // Limpia las opciones previas
        subcategorySelect.innerHTML = '<option selected>Selecciona primero una categoría</option>';
        subcategorySelect.disabled = true;

        if (categoryId) {
            // Realiza la solicitud AJAX para obtener las subcategorías
            fetch(`/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        subcategorySelect.disabled = false; // Habilitar el select de subcategorías
                        subcategorySelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';

                        // Añadir las subcategorías al select
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                        });
                    } else {
                        subcategorySelect.innerHTML = '<option selected>No hay subcategorías disponibles</option>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar las subcategorías:', error);
                });
        }
    });
});

