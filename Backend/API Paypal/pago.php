<?php
require 'vendor/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// Configurar credenciales de PayPal
$apiContext = new ApiContext(
    new OAuthTokenCredential('AWgZnde6LENtYx86KBDDmY6X6slBw5fef6Pfa7W8Rrdp1L1c5yX3mL-cuJoyBVACPxBqscr7Ii58Ukol', 'EGGkdXfZhVhGPEVkDYEbygObM1ranLGGtBDYH52Td55a5i1-13_Fgw7VFvY0cSkTGSPXmYTjh7Ioa4gb')
);
$apiContext->setConfig(['mode' => 'sandbox']); // Usar 'live' en producción

// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "tienda");
$producto_id = $_POST['producto_id'];

// Obtener detalles del producto
$resultado = $mysqli->query("SELECT * FROM habitaciones WHERE ID_HABITACION = $producto_id");
$producto = $resultado->fetch_assoc();

// Crear el pago
$payer = new Payer();
$payer->setPaymentMethod('paypal');

$item = new Item();
$item->setName($producto['TIPO'])
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setPrice($producto['PRECIOPORNOCHE'])
    ->setSku($producto['ID_HABITACION']);

$itemList = new ItemList();
$itemList->setItems([$item]);

$amount = new Amount();
$amount->setCurrency('USD')
    ->setTotal($producto['PRECIOPORNOCHE']);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription('Pago de prueba')
    ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("http://localhost/api/pago_exitoso.php?success=true")
    ->setCancelUrl("http://localhost/api/pago_exitoso.php?success=false");

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions([$transaction]);

try {
    $payment->create($apiContext);
    header("Location: " . $payment->getApprovalLink());
}
catch (PayPalConnectionException $ex) {
    echo $ex->getData();
}