<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/checkout', 'POST', [
    'event_id' => 1,
    'name' => 'John Doe',
    'email' => 'john@test.com',
    'phone' => '08000000',
    'quantity' => 1,
    'coupon_code' => 'SAVE10',
]);
$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Redirect: " . $response->headers->get('Location') . "\n";
