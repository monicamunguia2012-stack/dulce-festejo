/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', () => {

    // Función para reducir la barra de navegación al hacer scroll
    const navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Ejecutar al cargar la página y cada vez que se haga scroll
    navbarShrink();
    document.addEventListener('scroll', navbarShrink);

    // Activar ScrollSpy de Bootstrap en la barra de navegación principal
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    }

    // Contraer el menú móvil automáticamente al seleccionar una opción
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // --- CÓDIGO DE VALIDACIÓN DE LA DULCERÍA ---
    const form = document.getElementById('formProducto');
    const inputPrecio = document.getElementById('precio');
    const errorDOM = document.getElementById('errorDOM');

    if (form && inputPrecio && errorDOM) {
        // Limpiar el error en tiempo real al corregir el precio
        inputPrecio.addEventListener('input', () => {
            if (parseFloat(inputPrecio.value) > 0) {
                inputPrecio.classList.remove('is-invalid');
                errorDOM.style.display = 'none';
            }
        });

        // Validar al enviar el formulario
        form.addEventListener('submit', function (event) {
            const valor = parseFloat(inputPrecio.value);
            if (isNaN(valor) || valor <= 0) {
                event.preventDefault();
                errorDOM.textContent = 'El precio no puede ser cero o negativo.';
                errorDOM.style.display = 'block';
                inputPrecio.classList.add('is-invalid');
            }
        });
    }

    // Alerta de confirmación al eliminar un producto
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            if (!confirm('¿Seguro que deseas eliminar este artículo de Dulce Festejo?')) {
                event.preventDefault();
            }
        });
    });
});