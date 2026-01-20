<?php

// Go **up one level** from public/ to include vendor
require __DIR__ . '/../vendor/autoload.php';

use Algolia\AlgoliaSearch\Api\SearchClient;

// Make sure your .env values are correct
$appId = getenv('ALGOLIA_APP_ID');      // e.g. YCYYQL851T
$adminKey = getenv('ALGOLIA_SECRET');   // your Admin API key

try {
    $client = SearchClient::create(
        $appId,
        $adminKey,
        [
            'connectTimeout' => 10,
            'curlOptions' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // force IPv4
            ],
        ]
    );

    $indices = $client->listIndices();

    echo "<pre>";
    print_r($indices);
    echo "</pre>";
} catch (\Algolia\AlgoliaSearch\Exceptions\UnreachableException $e) {
    echo "Cannot connect to Algolia: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
