
<?php

//Este es un ejemplo que se realizo para otra base de datos, ENTONCES SOLO ES EJEMPLO DE MOMENTO.
require 'vendor/autoload.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// Configurar credenciales de PayPal
$apiContext = new ApiContext(
    new OAuthTokenCredential('AWgZnde6LENtYx86KBDDmY6X6slBw5fef6Pfa7W8Rrdp1L1c5yX3mL-cuJoyBVACPxBqscr7Ii58Ukol', 'EGGkdXfZhVhGPEVkDYEbygObM1ranLGGtBDYH52Td55a5i1-13_Fgw7VFvY0cSkTGSPXmYTjh7Ioa4gb')
);
$apiContext->setConfig(['mode' => 'sandbox']); // Usar 'live' en producción

// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "tienda");

if (isset($_GET['success']) && $_GET['success'] == 'true' && isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        // Ejecutar el pago
        $result = $payment->execute($execution, $apiContext);

        // Obtener ID del producto del pago
        $transactions = $result->getTransactions();
        $producto_id = $transactions[0]->getItemList()->getItems()[0]->getSku(); // Asegúrate de que SKU está configurado correctamente

        // Insertar en la base de datos
        $stmt = $mysqli->prepare("INSERT INTO pagos (producto_id, pago_id, estado, monto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $producto_id, $paymentId, $estado, $monto);

        $estado = $result->getState();
        $monto = $transactions[0]->getAmount()->getTotal();

        $stmt->execute();

        echo "Pago realizado con éxito.";
    } catch (Exception $ex) {
        echo "No se pudo realizar el pago: " . $ex->getMessage();
    }
} else {
    echo "Pago cancelado o no completado.";
}