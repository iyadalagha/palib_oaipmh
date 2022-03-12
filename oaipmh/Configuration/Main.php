<?php


$config = [

	//uri of database
	'dbUri'=>'localhost',
	
	// database username
	'dbUsername'=>'root',
	
	//database password
	'dbPassword'=>'',

    // A human readable name for the repository
    'repositoryName' => 'Palib Repository OAI Data Provider',

    // Email address for contacting the repository owner
    'adminEmail' => 'admin@example.org',

    // Do you provide 0-byte files for deleted records?
    //
    //  Possible values:
    //  "no" -> the repository does not maintain information about deletions
    //  "transient" -> the repository maintains information about deletions, but
    //                 does not guarantee them to be persistent (default)
    //  "persistent" -> the repository maintains information about deletions with
    //                  no time limit (recommended)
    // If you update your repository only via the ./update.php command, you can set
    // this to "persistent".
    'deletedRecord' => 'transient',

    // Metadata formats, schemas and namespaces of your records
    //
    //  The default is 'oai_dc' which is also required by the OAI-PMH specification,
    //  but technically you can provide any XML based data format you want. Just add
    //  another entry with the 'metadataPrefix' as key and schema/namespace URIs as
    //  array values or replace the default 'oai_dc' entry (not recommended).
    'metadataPrefix' => [
        'oai_dc' => [
            'schema' => 'http://www.openarchives.org/OAI/2.0/oai_dc.xsd',
            'namespace' => 'http://www.openarchives.org/OAI/2.0/oai_dc/',
        ],
    ],

    // Directory containing the records
    //
    //  Make sure the given path is readable and there is a subdirectory for every
    //  'metadataPrefix' you specified above. Although the given example points to
    //  a directory inside the document root it is highly recommended to place the
    //  data directory somewhere else. This will make upgrading so much easier and
    //  prevents users from accessing the records directly!
    'dataDirectory' => 'C:\oaidata',

    // Maximum number of records to return before giving a resumption token
    'maxRecords' => 100,

    // Absolute path and filename prefix for saving resumption tokens
    //
    //  Make sure the given path is writable.
    'tokenPrefix' => '/tmp/oai2-',

    // Number of seconds a resumption token should be valid
    'tokenValid' => 86400, // 24 hours

];
