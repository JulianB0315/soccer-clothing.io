// Función para agregar productos al carrito
function addToCart(productId) {
    // Obtener el formulario correspondiente al producto
    var form = document.getElementById("addToCartForm" + productId);
    var formData = new FormData(form);
    
    // Crear un objeto con la información del producto
    var product = {
        id: formData.get('product_id'),
        name: formData.get('product_name'),
        price: formData.get('product_price'),
        quantity: parseInt(formData.get('product_quantity'))
    };

    // Enviar la información al servidor usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_car.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                // Mostrar la notificación
                showNotification();
            } else {
                alert("Error al agregar al carrito");
            }
        }
    };

    // Enviar los datos del producto al servidor
    var data = "product_id=" + product.id + "&product_name=" + product.name + "&product_price=" + product.price + "&product_quantity=" + product.quantity;
    xhr.send(data);
}

// Función para mostrar la notificación
function showNotification() {
    var notification = document.getElementById("notification");
    notification.style.display = "block"; // Mostrar notificación
    setTimeout(function() {
        notification.style.display = "none"; // Ocultar después de 3 segundos
    }, 3000);
}

// Función para cerrar la notificación
function closeNotification() {
    var notification = document.getElementById("notification");
    notification.style.display = "none";
}
