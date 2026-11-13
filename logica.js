// ========== GESTIÓN DE CARRITO EN CLIENTE ==========

function obtenerCarrito() {
    var datos = localStorage.getItem('carrito_city_optica');
    return datos ? JSON.parse(datos) : [];
}

function guardarCarrito(carrito) {
    localStorage.setItem('carrito_city_optica', JSON.stringify(carrito));
}

function agregarAlCarrito(idProducto, nombre, precio) {
    var carrito = obtenerCarrito();
    
    // Verificar si el producto ya existe en el carrito
    var encontrado = false;
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id == idProducto) {
            carrito[i].cantidad += 1;
            encontrado = true;
            break;
        }
    }
    
    // Si no existe, agregarlo
    if (!encontrado) {
        carrito.push({
            id: idProducto,
            nombre: nombre,
            precio: precio,
            cantidad: 1
        });
    }
    
    guardarCarrito(carrito);
    mostrarNotificacionCarrito(nombre + ' agregado al carrito');
}

function eliminarDelCarrito(idProducto) {
    var carrito = obtenerCarrito();
    carrito = carrito.filter(function(item) {
        return item.id != idProducto;
    });
    guardarCarrito(carrito);
}

function actualizarCantidadCarrito(idProducto, cantidad) {
    var carrito = obtenerCarrito();
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id == idProducto) {
            carrito[i].cantidad = parseInt(cantidad);
            break;
        }
    }
    guardarCarrito(carrito);
}

function obtenerClientes() {
    var datos = localStorage.getItem('clientesOptica');
    return datos ? JSON.parse(datos) : [];
}

function guardarCliente() {
    var nombre = document.getElementById('nombre').value;
    var documento = document.getElementById('documento').value;
    var telefono = document.getElementById('telefono').value;
    var correo = document.getElementById('correo').value;
    var tipoLente = document.getElementById('tipoLente').value;

    if (nombre == '' || documento == '' || telefono == '' || correo == '' || tipoLente == '') {
        alert('Debe diligenciar todos los campos obligatorios.');
        return;
    }

    var clientes = obtenerClientes();
    var nuevo = {
        nombre: nombre,
        documento: documento,
        telefono: telefono,
        correo: correo,
        tipoLente: tipoLente
    };

    clientes.push(nuevo);
    localStorage.setItem('clientesOptica', JSON.stringify(clientes));
    alert('Cliente registrado correctamente.');

    document.getElementById('nombre').value = '';
    document.getElementById('documento').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('correo').value = '';
    document.getElementById('tipoLente').value = '';
}

function mostrarClientes() {
    var tbody = document.querySelector('#tablaClientes tbody');
    if (!tbody) {
        return;
    }

    var clientes = obtenerClientes();
    tbody.innerHTML = '';

    clientes.forEach(function(cliente) {
        var fila = document.createElement('tr');

        var c1 = document.createElement('td');
        c1.textContent = cliente.nombre;
        fila.appendChild(c1);

        var c2 = document.createElement('td');
        c2.textContent = cliente.documento;
        fila.appendChild(c2);

        var c3 = document.createElement('td');
        c3.textContent = cliente.telefono;
        fila.appendChild(c3);

        var c4 = document.createElement('td');
        c4.textContent = cliente.correo;
        fila.appendChild(c4);

        var c5 = document.createElement('td');
        c5.textContent = cliente.tipoLente;
        fila.appendChild(c5);

        tbody.appendChild(fila);
    });
}

// ========== VALIDACIONES ==========

function validarEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validarCedula(cedula) {
    return cedula.length >= 5 && cedula.length <= 15;
}

function validarTelefono(telefono) {
    var regex = /^[0-9\-\+\(\)\s]{7,}$/;
    return regex.test(telefono);
}

// ========== NOTIFICACIONES ==========

function mostrarNotificacionCarrito(mensaje) {
    var notificacion = document.createElement('div');
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #28a745;
        color: white;
        padding: 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideIn 0.3s ease-in-out;
        max-width: 400px;
        font-weight: 500;
    `;
    
    notificacion.innerHTML = `
        <div style="margin-bottom: 15px;">
            <strong>✓</strong> ${mensaje}
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <button onclick="window.location.href='carrito.php'" style="background: white; color: #28a745; border: none; padding: 8px 15px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Ver carrito
            </button>
            <button onclick="this.parentElement.parentElement.remove()" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 8px 15px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Continuar
            </button>
        </div>
    `;
    document.body.appendChild(notificacion);
    
    setTimeout(function() {
        if (notificacion.parentElement) {
            notificacion.style.animation = 'slideOut 0.3s ease-in-out';
            setTimeout(function() {
                if (notificacion.parentElement) notificacion.remove();
            }, 300);
        }
    }, 5000);
}

function mostrarNotificacion(mensaje, tipo) {
    // tipo puede ser: 'success', 'error', 'warning', 'info'
    
    var colores = {
        'success': '#28a745',
        'error': '#dc3545',
        'warning': '#ffc107',
        'info': '#17a2b8'
    };
    
    var iconos = {
        'success': '✓',
        'error': '✕',
        'warning': '⚠',
        'info': 'ℹ'
    };
    
    var notificacion = document.createElement('div');
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${colores[tipo] || colores['info']};
        color: white;
        padding: 15px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideIn 0.3s ease-in-out;
        max-width: 400px;
        font-weight: 500;
    `;
    
    notificacion.innerHTML = `<strong>${iconos[tipo]}</strong> ${mensaje}`;
    document.body.appendChild(notificacion);
    
    setTimeout(function() {
        notificacion.style.animation = 'slideOut 0.3s ease-in-out';
        setTimeout(function() {
            notificacion.remove();
        }, 300);
    }, 3000);
}

// ========== ANIMACIONES CSS ==========

var style = document.createElement('style');
style.innerHTML = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ========== CARRUSEL BANNER PRINCIPAL ==========
if (typeof jQuery !== 'undefined') {
    jQuery(document).ready(function($) {
        var $carrusel = $('#carrusel-principal');
        if ($carrusel.length) {
            // Asegurar inicialización de Bootstrap Carousel
            if (typeof $carrusel.carousel === 'function') {
                $carrusel.carousel({
                    interval: 5000,
                    pause: 'hover',
                    keyboard: true,
                    wrap: true
                });
            }

            // Manejador garantizado para la flecha izquierda (Anterior)
            $carrusel.find('.carousel-control-prev').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $carrusel.carousel('prev');
            });

            // Manejador garantizado para la flecha derecha (Siguiente)
            $carrusel.find('.carousel-control-next').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $carrusel.carousel('next');
            });

            // Manejador para los indicadores inferiores
            $carrusel.find('.carousel-indicators li').on('click', function(e) {
                var indice = $(this).attr('data-slide-to');
                if (indice !== undefined) {
                    e.preventDefault();
                    e.stopPropagation();
                    $carrusel.carousel(parseInt(indice, 10));
                }
            });
        }
    });
}

