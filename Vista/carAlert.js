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

document.addEventListener("DOMContentLoaded", function() {
    const userLink = document.getElementById('user-link');

    // Verifica si el enlace existe en el DOM
    if (userLink) {
        // Añadir el evento de clic
        userLink.addEventListener('click', function() {
            // Obtener el id del cliente desde sessionStorage
            const idCliente = sessionStorage.getItem('id_cliente');
            
            // Imprimir el id en la consola
            console.log("ID del cliente:", idCliente);
        });
    }
});

// Cuando el usuario intenta salir de la página (cerrar pestaña o navegador)
window.addEventListener("beforeunload", function () {
    // Borrar los datos almacenados en sessionStorage
    sessionStorage.removeItem('id_cliente');
    sessionStorage.removeItem('email');
    fetch('../Controlador/cerrar_sesion.php', { method: 'POST' });
});
//para el bton de cerrar sesión en el servidor
function cerrarSesion() {
    // Eliminar datos de sessionStorage
    sessionStorage.removeItem('id_cliente');
    sessionStorage.removeItem('email');

    // Redirigir a la página que cierra la sesión en el servidor
    window.location.href = '../Controlador/cerrar_sesion.php';
}