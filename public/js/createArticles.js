document.addEventListener("DOMContentLoaded", function () {
    const categoriaSelect = document.getElementById("categoria");
    const subcategoriaSelect = document.getElementById("subcategoria");

    categoriaSelect.addEventListener("change", function () {
        const categoriaId = this.value;

        // Si no hay una categoría seleccionada, deshabilitar el select de subcategorías
        if (!categoriaId) {
            subcategoriaSelect.innerHTML = '<option selected>Selecciona primero una categoría</option>';
            subcategoriaSelect.disabled = true;
            return;
        }

        // Realizar la solicitud AJAX
        fetch(`/subcategorias/get-subcategorias/${categoriaId}`)
        .then(response => {
                if (!response.ok) {
                    throw new Error("Error al cargar las subcategorías");
                }
                return response.json();
            })
            .then(data => {
                // Limpiar el select de subcategorías
                subcategoriaSelect.innerHTML = '';

                if (data.length > 0) {
                    // Poblar el select con las subcategorías
                    data.forEach(subcategoria => {
                        const option = document.createElement("option");
                        option.value = subcategoria.id;
                        option.textContent = subcategoria.name;
                        subcategoriaSelect.appendChild(option);
                    });
                    subcategoriaSelect.disabled = false;
                } else {
                    subcategoriaSelect.innerHTML = '<option selected>No hay subcategorías disponibles</option>';
                    subcategoriaSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error(error);
                subcategoriaSelect.innerHTML = '<option selected>Error al cargar subcategorías</option>';
                subcategoriaSelect.disabled = true;
            });
    });
});
