<?php
require_once("../vendor/autoload.php");
require_once("params.php");
$app = new \Slim\Slim();
$app->cache = [
    "fieldsCache"=>realpath(__DIR__ . "/../cache/fields.json"),
    "cacheTime"=>86400,
];
$app->emarsys = [
    "username"=>$params["username"],
    "secret"=>$params["secret"],
    "url"=>$params["url"]
];

$app->get("/", function() use ($app){


    $eClient = new \Nico\Emarsys\CachedClient(
        new \GuzzleHttp\Client(),
        $app->emarsys["username"],
        $app->emarsys["secret"],
        $app->emarsys["url"],
        "fr",
        $app->cache["fieldsCache"],
        $app->cache["cacheTime"]
    );
    //$response = $eClient->getFields();
    $response = $eClient->getFieldName(26, true);
    //$response = $eClient->getFieldChoices(31,false);
    //$response = $eClient->createSingleChoiceField("Est parrain");
    echo "<html><head><meta charset='utf-8'></head><body><pre>".var_dump($response)."</pre></body>";
});

$app->run();
