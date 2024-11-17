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
    notification.classList.remove("desaparecer"); // Quita la animación de salida si existe
    notification.classList.add("aparecer"); // Agrega la animación de entrada
    notification.style.display = "block"; // Mostrar notificación
    setTimeout(function() {
        notification.classList.remove("aparecer");
        notification.classList.add("desaparecer");

        // Espera a que termine la animación de salida antes de ocultarlo
        setTimeout(function() {
            notification.style.display = "none";
            notification.classList.remove("fade-out"); // Limpia la clase de salida
        }, 500); // Duración de la animación de salida (en ms)
    }, 3000); // Tiempo de espera antes de desaparecer
}

// Función para cerrar la notificación
function closeNotification() {
    var notification = document.getElementById("notification");
    notification.classList.remove("aparecer");
    notification.classList.add("desaparecer");
    setTimeout(function() {
        notification.style.display = "none";
        notification.classList.remove("desaparecer");
    }, 500);
}

// Función para vaciar el carrito
function clearCart() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "shop.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("action=clear_cart");
}

/*Cargar los datos del cliente */
// Obtener los valores guardados previamente en sessionStorage
const idCliente = sessionStorage.getItem('id_cliente');
const email = sessionStorage.getItem('email');

//para el bton de cerrar sesión en el servidor
function cerrarSesion() {
    // Eliminar datos de sessionStorage
    sessionStorage.removeItem('id_cliente');
    sessionStorage.removeItem('email');

    // Redirigir a la página que cierra la sesión en el servidor
    window.location.href = '../Controlador/cerrar_sesion.php';
}