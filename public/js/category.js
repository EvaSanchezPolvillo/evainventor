document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("categoriesTable");

    table.addEventListener("click", function (event) {
        if (event.target.closest(".btn-delete")) {
            const row = event.target.closest("tr"); // Obtén la fila del botón clicado
            const categoryId = row.querySelector("td").innerText.trim(); // Toma el ID de la categoría

            if (!confirm("¿Estás seguro de que deseas eliminar esta categoría y sus subcategorías?")) {
                return;
            }

            // Realizar la solicitud DELETE
            fetch(`/categorias/delete/${categoryId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al eliminar la categoría.");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert("Categoría y subcategorías eliminadas con éxito.");
                        row.remove(); // Elimina la fila de la tabla
                    } else {
                        alert("Hubo un problema al eliminar la categoría.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al eliminar la categoría.");
                });
        }
    });
});
