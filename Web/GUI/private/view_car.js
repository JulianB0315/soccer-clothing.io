document.addEventListener("DOMContentLoaded", function () {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const cartTableBody = document.querySelector("#cartTable tbody");
    const totalAmountEl = document.getElementById("totalAmount");

    let totalAmount = 0;

    if (cartItems.length === 0) {
        cartTableBody.innerHTML = '<tr><td colspan="5" class="text-center">El carrito está vacío</td></tr>';
    } else {
        cartItems.forEach((item, index) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${item.name}</td>
                <td>S/. ${parseFloat(item.price).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                    <span class="mx-2">${item.quantity}</span>
                    <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                </td>
                <td>S/. ${(item.price * item.quantity).toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Eliminar</button>
                </td>
            `;

            cartTableBody.appendChild(row);
            totalAmount += item.price * item.quantity;
        });
    }

    totalAmountEl.textContent = `Total: S/. ${totalAmount.toFixed(2)}`;
});

function removeItem(index) {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    cartItems.splice(index, 1);
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    location.reload();
}

function updateQuantity(index, change) {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    cartItems[index].quantity = Math.max(1, cartItems[index].quantity + change);
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    location.reload();
}

function clearCart() {
    localStorage.removeItem("cartItems");
    location.reload();
}

// Agregar un botón para limpiar el carrito
document.getElementById('clearCartButton').addEventListener('click', clearCart);