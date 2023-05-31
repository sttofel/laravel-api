<?php

namespace App\Repositories;

use App\Models\Message;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;
use SimpleXMLElement;

class StatusRepository
{
    protected $entity;

    public function __construct(Message $message){
        $this->entity = $message;
    }

    public function index($document) {
        $message = $this->entity->where('document', $document)->first();

        $response = consultaWS($document);

       $json = retornoWS($response, $document);

        if (!empty($message)){
           $messageId = sendTelegram($json, $message->telegram);
           $message->update([
               'telegram' => $messageId
           ]);
           $message->save();
       }
       sendDiscord($json);

        return $json;
    }
}
