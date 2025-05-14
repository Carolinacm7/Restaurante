// Aumentar o disminuir cantidad
function cambiarCantidad(id, cambio) {
  const input = document.getElementById('cantidad_' + id);
  let valor = parseInt(input.value) + cambio;
  if (valor < 0) valor = 0;
  input.value = valor;
}

// Validar que al menos un producto esté seleccionado con cantidad > 0
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");

  form.addEventListener("submit", function (event) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="productos[]"]');
    let alMenosUnoSeleccionado = false;

    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        const id = checkbox.value;
        const cantidadInput = document.getElementById("cantidad_" + id);
        const cantidad = parseInt(cantidadInput.value, 10);

        if (cantidad > 0) {
          alMenosUnoSeleccionado = true;
        }
      }
    });

    if (!alMenosUnoSeleccionado) {
      alert("Por favor selecciona al menos un producto ✔ y luego selecciona la  cantidad.");
      event.preventDefault();
    }
  });
});
