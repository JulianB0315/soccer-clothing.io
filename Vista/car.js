// Selecciona todos los botones de añadir al carrito
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Obtiene los datos del producto del mismo contenedor de la tarjeta
        const card = button.closest('.card-body');
        const productId = card.querySelector('.product-id').value;
        const productName = card.querySelector('.product-name').value;
        const productPrice = card.querySelector('.product-price').value;
        const productQuantity = card.querySelector('.product-quantity').value;

        // Crea el objeto de datos
        const productData = {
            product_id: productId,
            product_name: productName,
            product_price: productPrice,
            product_quantity: productQuantity,
        };

        // Envía la solicitud AJAX a `Shop.php`
        fetch('../../public/Shop.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`Producto "${productName}" añadido al carrito`);
                // Aquí podrías actualizar la UI para reflejar que el producto se añadió
            } else {
                alert(`Error al añadir el producto: ${data.message || 'Razón desconocida'}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al añadir el producto al carrito. Por favor, inténtalo de nuevo.');
        });
    });
});