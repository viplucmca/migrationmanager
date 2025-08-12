<?php

require 'vendor/autoload.php';

use Hfig\MAPI;
use Hfig\MAPI\OLE\Pear;

// message parsing and file IO are kept separate
$messageFactory = new MAPI\MapiMessageFactory();
$documentFactory = new Pear\DocumentFactory(); 

$ole = $documentFactory->createFromFile('source-file.msg');
$message = $messageFactory->parseMessage($ole);

// raw properties are available from the "properties" member
echo $message->properties['subject'], "\n";

// some properties have helper methods
echo $message->getSender(), "\n";
echo $message->getBody(), "\n";

// recipients and attachments are composed objects
foreach ($message->getRecipients() as $recipient) {
    // eg "To: John Smith <john.smith@example.com>
    echo sprintf('%s: %s', $recipient->getType(), (string)$recipient), "\n";
}
?>
