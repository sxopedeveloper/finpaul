<?php
// Authentication things above
/*
 * Decode the body.
 * @param : encoded body  - or null
 * @return : the body if found, else FALSE;
 */
function decodeBody($body) {
    $rawData = $body;
    $sanitizedData = strtr($rawData,'-_', '+/');
    $decodedMessage = base64_decode($sanitizedData);
    if(!$decodedMessage){
        $decodedMessage = FALSE;
    }
    return $decodedMessage;
}

$client = getClient();
$gmail = new Google_Service_Gmail($client);

$list = $gmail->users_messages->listUsersMessages('me', ['maxResults' => 1000]);

try{
    while ($list->getMessages() != null) {

        foreach ($list->getMessages() as $mlist) {

            $message_id = $mlist->id;
            $optParamsGet2['format'] = 'full';
            $single_message = $gmail->users_messages->get('me', $message_id, $optParamsGet2);
            $payload = $single_message->getPayload();

            // With no attachment, the payload might be directly in the body, encoded.
            $body = $payload->getBody();
            $FOUND_BODY = decodeBody($body['data']);

            // If we didn't find a body, let's look for the parts
            if(!$FOUND_BODY) {
                $parts = $payload->getParts();
                foreach ($parts  as $part) {
                    if($part['body']) {
                        $FOUND_BODY = decodeBody($part['body']->data);
                        break;
                    }
                    // Last try: if we didn't find the body in the first parts, 
                    // let's loop into the parts of the parts (as @Tholle suggested).
                    if($part['parts'] && !$FOUND_BODY) {
                        foreach ($part['parts'] as $p) {
                            // replace 'text/html' by 'text/plain' if you prefer
                            if($p['mimeType'] === 'text/html' && $p['body']) {
                                $FOUND_BODY = decodeBody($p['body']->data);
                                break;
                            }
                        }
                    }
                    if($FOUND_BODY) {
                        break;
                    }
                }
            }
            // Finally, print the message ID and the body
            print_r($message_id . " : " . $FOUND_BODY);
        }

        if ($list->getNextPageToken() != null) {
            $pageToken = $list->getNextPageToken();
            $list = $gmail->users_messages->listUsersMessages('me', ['pageToken' => $pageToken, 'maxResults' => 1000]);
        } else {
            break;
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}