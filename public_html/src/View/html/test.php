<?php

header("Content-Type: application/json; charset=utf-8");

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
    <quantity>".$item["amount"]."</quantity>
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
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_URL => "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout?email=caiquegl@hotmail.com&token=431084DF543C4A6583B249B723BAA387",
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/xml; charset=ISO-8859-1"
    )
));

$result = curl_exec($ch);
echo $result;