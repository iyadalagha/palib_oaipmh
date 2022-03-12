<?php


use OCC\OAI2\Exception;
use OCC\OAI2\Server;
use OCC\OAI2\PalibDBConnector;

// Register PSR-4 autoloader
require __DIR__.'/vendor/autoload.php';

// Load configuration
require __DIR__.'/Configuration/Main.php';

// Get all available records and their respective status and timestamps
$records = [];
//$deleted = [];
$itemstamps = [];
$timestamps = [];
$earliest = time();
$palibDB = new PalibDBConnector($config['dbUri'], $config['dbUsername'], $config['dbPassword']);

foreach ($config['metadataPrefix'] as $prefix => $uris) {
	
		/*
    $files = glob(rtrim($config['dataDirectory'], '/').'/'.$prefix.'/*.xml');	
	foreach ($files as $file) {
        $records[$prefix][pathinfo($file, PATHINFO_FILENAME)] = $file;
        $deleted[$prefix][pathinfo($file, PATHINFO_FILENAME)] = !filesize($file);
        $timestamps[$prefix][filemtime($file)][] = pathinfo($file, PATHINFO_FILENAME);
        if (filemtime($file) < $earliest) {
            $earliest = filemtime($file);
        }
    }
	*/
	
	
	$items = $palibDB->getAllItems();
	foreach ($items as $item) {
       $records[$prefix][$item->id] = $item->id;
       $timestamps[$prefix][strtotime($item->datestamp)][] = $item->id;
	   $itemstamps[$item->id]=strtotime($item->datestamp);
	   if (strtotime($item->datestamp) < $earliest) {
          $earliest = strtotime($item->datestamp);
       }
	}
    
	
    ksort($records[$prefix]);
    reset($records[$prefix]);
    ksort($timestamps[$prefix]);
    reset($timestamps[$prefix]);

}

// Get current base URL
$baseURL = $_SERVER['HTTP_HOST'].parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $baseURL = 'https://'.$baseURL;
} else {
    $baseURL = 'http://'.$baseURL;
}

// Build the Identify response
$identifyResponse = [
    'repositoryName' => $config['repositoryName'],
    'baseURL' => $baseURL,
    'protocolVersion' => '2.0',
    'adminEmail' => $config['adminEmail'],
    'earliestDatestamp' => gmdate('Y-m-d\TH:i:s\Z', $earliest),
    'deletedRecord' => $config['deletedRecord'],
    'granularity' => 'YYYY-MM-DDThh:mm:ssZ'
];

$oai2 = new Server($palibDB,
    $baseURL,
    $_GET,
    $identifyResponse,
    [
        'GetRecord' => function ($identifier, $metadataPrefix) {
            global $records, $deleted, $itemstamps;
            if (empty($records[$metadataPrefix][$identifier])) {
                return [];
            } else {
                return [
                    'identifier' => $identifier,
                    //'timestamp' => filemtime($records[$metadataPrefix][$identifier]),
					'timestamp' => $itemstamps[$identifier],
                    //'deleted' => $deleted[$metadataPrefix][$identifier],
                    'metadata' => $records[$metadataPrefix][$identifier]
                ];
            }
        },
        'ListRecords' => function ($metadataPrefix, $from = null, $until = null, $count = false, $deliveredRecords = 0, $maxItems = 100) {
			global $records, $deleted, $timestamps, $itemstamps;
            $resultSet = [];
			foreach ($timestamps[$metadataPrefix] as $timestamp => $identifiers) {
                //if ((is_null($from) || $timestamp >= $from) && (is_null($until) || $timestamp <= $until)) {

                    foreach ($identifiers as $identifier) {
                        $resultSet[] = [
                            'identifier' => $identifier,
                            //'timestamp' => filemtime($records[$metadataPrefix][$identifier]),
							'timestamp' => $itemstamps[$identifier],
                            //'deleted' => $deleted[$metadataPrefix][$identifier],
                            'metadata' => $records[$metadataPrefix][$identifier]
                        ];
                    }
                //}
            }
            if ($count) {
                return count($resultSet);
            } else {
                return array_slice($resultSet, $deliveredRecords, $maxItems);
            }
        },
        'ListMetadataFormats' => function ($identifier = '') {
            global $config, $records;
            if (!empty($identifier)) {
                $formats = [];
                foreach ($records as $format => $record) {
                    if (!empty($record[$identifier])) {
                        $formats[$format] = $config['metadataPrefix'][$format];
                    }
                }
                if (!empty($formats)) {
                    return $formats;
                } else {
                    throw new Exception('idDoesNotExist');
                }
            } else {
                return $config['metadataPrefix'];
            }
        }
    ],
    $config
);

$response = $oai2->response();
if (isset($return)) {
    return $response;
} else {
    $response->formatOutput = true;
    $response->preserveWhiteSpace = false;
    header('Content-Type: text/xml');
    echo $response->saveXML();

   
}
