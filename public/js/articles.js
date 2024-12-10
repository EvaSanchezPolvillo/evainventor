$(document).ready(function () {
    $('#articlesTable').DataTable({
        responsive: true, // Hace la tabla responsiva
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // Traducción al español
        },
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("articlesTable");

    table.addEventListener("click", function (event) {
        if (event.target.closest(".btn-delete")) {
            const row = event.target.closest("tr"); // Obtén la fila del botón clicado
            const articuloId = row.querySelector("td").innerText.trim(); // Toma el valor de la primera celda (ID)

            if (!confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
                return;
            }

            // Realizar la solicitud DELETE
            fetch(`/articulos/delete/${articuloId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al eliminar el artículo.");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Artículo eliminado con éxito.");
                        row.remove(); // Elimina la fila de la tabla
                    } else {
                        alert("Hubo un problema al eliminar el artículo.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al eliminar el artículo.");
                });
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("articlesTable");

    table.addEventListener("dblclick", function (event) {
        const cell = event.target.closest("td"); // Detectar la celda donde ocurrió el doble clic
        if (!cell) return;

        const row = cell.closest("tr"); // Obtener la fila asociada
        const articuloId = row.children[0].innerText.trim(); // Asumimos que la primera celda contiene el ID
        const column = table.querySelector(`thead th:nth-child(${cell.cellIndex + 1})`)?.getAttribute("data-column");
        const originalValue = cell.innerText.trim();

        if (!column || column === "subcategory" || column === "imagen") return; // Ignorar columnas no editables

        // Crear un campo de entrada para la edición
        const input = document.createElement("input");
        input.type = "text";
        input.value = originalValue;
        input.classList.add("form-control");
        cell.innerHTML = ""; // Limpiar la celda
        cell.appendChild(input);
        input.focus();

        // Guardar cambios al perder el foco
        input.addEventListener("blur", function () {
            const newValue = input.value.trim();

            if (newValue === originalValue) {
                cell.innerText = originalValue; // Restaurar si no hubo cambios
                return;
            }

            // Enviar la actualización al servidor
            fetch(`/articulos/${articuloId}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({
                    column: column,
                    value: newValue,
                }),
            })
                .then(response => {
                    if (!response.ok) throw new Error("Error al actualizar el artículo");
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        cell.innerText = newValue; // Actualizar la celda
                    } else {
                        cell.innerText = originalValue; // Restaurar si hubo error
                        alert("Error al actualizar el artículo.");
                    }
                })
                .catch(error => {
                    console.error(error);
                    cell.innerText = originalValue; // Restaurar si ocurrió un error
                    alert("Ocurrió un error al actualizar el artículo.");
                });
        });

        // Guardar cambios al presionar Enter
        input.addEventListener("keydown", function (event) {
            if (event.key === "Enter") input.blur();
        });
    });
});
