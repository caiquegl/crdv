<?php

require_once( dirname(__DIR__,2).'/vendor/autoload.php' );

//Paypal Classes
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
// End Paypal Classes

if(isset($_POST["paymentSDK"]) && ($_POST["paymentSDK"] === "mercadopago")){
    
    header( "Content-type: application/json" );

    $tokenMercadoPago = "TEST-3456282241922594-060320-15c35aa32e719ec26d4448ae1895d5fc-578970141";

    $postRequired = array(
        "transactionAmount", "token", "description", "installments", "paymentMethodId",
        "issuer", "email", "docType", "docNumber"
    );

    if(!(count($_POST)-1 === count($postRequired))) {
        die(json_encode(array(
            "error" => "Parâmetros inválidos"
        )));
    }

    foreach($postRequired as $field){
        if(empty($_POST[$field])){
            die(json_encode(array(
                "error" => "O parâmetro $field está inválido."
            )));
        }
    }

    MercadoPago\SDK::setAccessToken($tokenMercadoPago);
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = (float)$_POST['transactionAmount'];
    $payment->token = $_POST['token'];
    $payment->description = $_POST['description'];
    $payment->installments = (int)$_POST['installments'];
    $payment->payment_method_id = $_POST['paymentMethodId'];
    $payment->issuer_id = (int)$_POST['issuer'];

    $payer = new MercadoPago\Payer();
    $payer->email = $_POST['email'];
    $payer->identification = array(
        "type" => $_POST['docType'],
        "number" => $_POST['docNumber']
    );  

    $payment->payer = $payer;

    $payment->save();

    $response = array(
        'status' => $payment->status,
        'status_detail' => $payment->status_detail,
        'id' => $payment->id
    );
    echo json_encode($response);
} elseif(isset($_POST["paymentSDK"]) && ($_POST["paymentSDK"] === "paypal")){
    header( "Content-type: application/json" );

    $postRequired = array(
        "products", "taxa", "frete", "subTotal"
    );

    if(!(count($_POST) === count($postRequired))) {
        die(json_encode(array(
            "error" => "Parâmetros inválidos"
        )));
    }

    foreach($postRequired as $field){
        if(empty($_POST[$field])){
            die(json_encode(array(
                "error" => "O parâmetro $field está inválido."
            )));
        }
    }

    $items = json_decode($_POST["products"]);
    $countItens = count($items);
    $productsArrayForItemList = array();
   
    $total = ((Float) $_POST["frete"]) + ((Float) $_POST["taxa"]);

    for($i = 0; $i < $countItens; $i++){
        $item1 = new Item();
        $item1->setName($item[$i]->name)
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setSku($item[$i]->sku) // Similar to `item_number` in Classic API
            ->setPrice((Float) $item[$i]->price);
        $total += (Float) $item[$i]->price;
        array_push($productsArrayForItemList, $item1);
    }
    
    $payer = new Payer();
    $payer->setPaymentMethod("paypal");
    
    $itemList = new ItemList();
    $itemList->setItems($productsArrayForItemList);

    $details = new Details();
    $details->setShipping((Float) $_POST["frete"])
        ->setTax((Float) $_POST["taxa"])
        ->setSubtotal((Float) $_POST["subTotal"]);

    $amount = new Amount();
    $amount->setCurrency("BRL")
    ->setTotal($total)
    ->setDetails($details);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription($_POST["description"])
        ->setInvoiceNumber(uniqid());
    
    $baseUrl = "http://" . $_SERVER['SERVER_NAME'] . explode("/CheckoutPayment.php",$_SERVER['REQUEST_URI'])[0];
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
        ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");
        $payment = new Payment();
    $payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
    $request = clone $payment;
    try {
        $payment->create($apiContext);
    } catch (Exception $e) {
       var_dump("Created Payment Using PayPal. Please visit the URL to Approve. Payment, null, $request, $ex");
        exit(1);
        
    }
    $approvalUrl = $payment->getApprovalLink();
    var_dump("Created Payment Using PayPal. Please visit the URL to Approve., Payment, <a href='$approvalUrl' >$approvalUrl</a>, $request, $payment");

    return $payment;
} elseif(isset($_POST["paymentSDK"]) && ($_POST["paymentSDK"] === "pagseguro")){
    
    header( "Content-type: application/xml" );

    $postRequired = array(
        "paymentMode", "paymentMethod", "receiverEmail", "currency", "extraAmount", "items", "notificationURL", "reference", 
        "senderName", "senderCPF", "senderAreaCode", "senderPhone", "senderEmail", "senderHash", "shippingAddressRequired",
        "shippingAddressNumber", "shippingAddressComplement", "shippingAddressDistrict", "shippingAddressPostalCode",
        "shippingAddressCity", "shippingAddressState", "shippingAddressCountry", "shippingType", "shippingCost"
    );

    if(!(count($_POST)-1 === count($postRequired))) {
        die(json_encode(array(
            "error" => "Parâmetros inválidos"
        )));
    }

    $params = array();

    foreach($postRequired as $field){
        if(empty($_POST[$field])){
            die(json_encode(array(
                "error" => "O parâmetro $field está inválido."
            )));
        } else {
            $params[$field] = $_POST[$field];
        }
    }

    $ch = curl_init();

    $params = "<checkout>
    <sender>
    <name>".$_POST["name"]."</name>
    <email>".$_POST["email"]."</email>
    <phone>
        <areaCode>".$_POST["areaCode"]."</areaCode>
        <number>".$_POST["number"]."</number>
    </phone>
    <documents>
        <document>
        <type>".$_POST["type"]."</type>
        <value>".$_POST["value"]."</value>
        </document>
    </documents>
    </sender>
    <currency>".$currency."</currency>
    <items>";

    $items = json_decode($_POST["items"]);
    var_dump($items,$_POST["items"]);
    if(!$items){
        die(json_encode(array(
            "error" => "Má formação da lista de items."
        )));
    }

    foreach($items as $item){
        $params += "<item>
        <id>".$item["id"]."</id>
        <description>".$item["description"]."</description>
        <amount>".$item["amount"]."</amount>
        <quantity>".$item["qtd"]."</quantity>
        <weight>".$item["weight"]."</weight>
        <shippingCost>".$item["shippingCost"]."</shippingCost>
    </item>";

    }

    $param += "</items>
        <redirectURL>".$return."</redirectURL>
        <extraAmount>".$_POST["extraAmount"]."</extraAmount>
        <reference>".$_POST["reference"]."</reference>
        <shipping>
        <address>
            <street>".$_POST["street"]."</street>
            <number>".$_POST["number"]."</number>
            <complement>".$_POST["complement"]."</complement>
            <district>".$_POST["district"]."</district>
            <city>".$_POST["city"]."</city>
            <state>".$_POST["state"]."</state>
            <country>".$_POST["country"]."</country>
            <postalCode>".$_POST["postalCode"]."</postalCode>
        </address>
        <type>".$_POST["type"]."</type>
        <cost>".$_POST["cost"]."</cost>
        <addressRequired>".$_POST["addressRequired"]."</addressRequired>
        </shipping>
        <timeout>25</timeout>
        <maxAge>999999999</maxAge>
        <maxUses>999</maxUses>
        <receiver>
        <email>".$_POST["email"]."</email>
        </receiver>
        <enableRecover>false</enableRecover>
    </checkout>";

    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions", // SANDBOX
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
    ));

    $response = curl_exec($ch);

    echo $response;
} elseif(isset($_POST["paymentSDK"]) && ($_POST["paymentSDK"] === "boleto")){
    
    header("Content-Type: application/json; charset=utf-8");
    
    $config = array(
        "token" => "apk_44331092-GOMdCmQOXlMzfGzIkWFyRQqBqCuihzFn",
        "type_bank_slip" => "boletoA4",
        "days_due_date" => "3"
    
    );
    
    $reqParams = array("order_id","payer_name","payer_cpf_cnpj","payer_email","items");
    
    foreach($reqParams as $field){
        if((!isset($_POST[$field])) OR empty($_POST[$field])){
            die(json_encode(array(
                "error" => "O parâmetro $field está inválido."
            )));
        }
    
    }
    $params = array(
        "apiKey"=>$config["token"],
        "order_id"=>$_POST["order_id"],
        "type_bank_slip"=>$config["type_bank_slip"],
        "days_due_date"=> $config["days_due_date"],
        "payer_name"=> $_POST["payer_name"],
        "payer_cpf_cnpj"=> $_POST["payer_cpf_cnpj"],
        "payer_email"=> $_POST["payer_email"],
        "items" => array()
    );
    foreach($_POST["items"] as $item) {
        array_push($params["items"], array(
            "description" => $item["description"],
            "quantity" => $item["quantity"],
            "item_id" => $item["item_id"],
            "price_cents" => $item["price_cents"]
        ));
    }
    $params = json_encode($params);
    $ch = curl_init();
    
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_URL => "https://api.paghiper.com/transaction/create/",
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        )
    ));
    
    $result = curl_exec($ch);
    
    echo $result;

} else {
    die(json_encode(array(
        "error" => "Plataforma de Pagamento inválida"
    )));
}