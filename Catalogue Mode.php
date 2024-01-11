<?php
//Codigo escrito el 11/01/2024
//Pone la tienda en modo "catalogo", oculta precios y desactiva pedidos: Yith request a quote es una mejor alternativa a esto.

add_filter('woocommerce_order_button_text', 'custom_order_button_text');
function custom_order_button_text() {
    return __('Hacer consulta', 'woocommerce');
}

 // Ocultar precios
if (!function_exists('custom_price_message')) {
    add_filter('woocommerce_get_price_html', 'custom_price_message');
    function custom_price_message($price) {
        return ""; // Esto ocultará todos los precios
    }
}


// Cambiar el texto del botón "Finalizar compra" a "Hacer pedido"
if (!function_exists('custom_order_button_text')) {
    add_filter('woocommerce_order_button_text', 'custom_order_button_text');
    function custom_order_button_text() {
        return __('Hacer consulta', 'woocommerce');
    }
}

// Crear un pedido sin precio cuando se haga clic en el botón "Hacer pedido"
if (!function_exists('custom_new_order')) {
    add_action('woocommerce_new_order', 'custom_new_order');
    function custom_new_order($order_id) {
        // Obtener el pedido
        $order = wc_get_order($order_id);

        // Recorrer los productos del pedido
        foreach($order->get_items() as $item) {
            // Establecer el precio del producto a 0
            $item->set_subtotal(0);
            $item->set_total(0);
        }

        // Guardar el pedido
        $order->calculate_totals();
    }
}