<?php


use Atakde\DiscordWebhook\DiscordWebhook;
use Atakde\DiscordWebhook\Message\MessageFactory;
use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;

if (!function_exists('inicializaAmbiente')){
    function inicializaAmbiente(){
        date_default_timezone_set('America/Sao_Paulo');
        $arr = [
            "atualizacao" => "2016-11-03 18:01:21",
            "tpAmb" => (Integer) env('AMBIENTE'),
            "razaosocial" => env('RAZAO'),
            "cnpj" => env('CNPJ'),
            "siglaUF" => env('UF'),
            "schemes" => "PL_009_V4",
            "versao" => '4.00',
        ];

        $configJson = json_encode($arr);
        $content = file_get_contents(public_path('assets/certificate/'.env('CERT')));
        return ['content' => $content, 'json' => $configJson];
    }
}

if (!function_exists('consultaWS')){
    function consultaWS($document){
        $data = inicializaAmbiente();
        try {
            $tools = new Tools($data['json'], Certificate::readPfx($data['content'], env('CERT_PW')));
            $tools->model($document);
            $response = $tools->sefazStatus('RJ');
            header('Content-type: text/json; charset=UTF-8');
        } catch (Exception $err){
            echo json_encode(['error' => $err->getMessage()]);
        }

        return $response;
    }
}

if (!function_exists('retornoWS')){
    function retornoWS($response, $document){
        try {
            $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
            $xml = new SimpleXMLElement($response);
            $array = json_decode( str_replace('@', '', json_encode($xml)), TRUE);
            $tpAmb = $array['soapBody']['nfeResultMsg']['retConsStatServ']['tpAmb'];
            $verAplic = $array['soapBody']['nfeResultMsg']['retConsStatServ']['verAplic'];
            $cStat = $array['soapBody']['nfeResultMsg']['retConsStatServ']['cStat'];
            $xMotivo = $array['soapBody']['nfeResultMsg']['retConsStatServ']['xMotivo'];
            $cUf = $array['soapBody']['nfeResultMsg']['retConsStatServ']['cUF'];
            $cStatarray = ['107', '108', '109'];
            if (!$cStat == is_array($cStatarray)){
                $cStat = '109';
                $xMotivo = "Serviço Paralisado sem Previsão";
            }
            $json = [
                'tpAmb' => $tpAmb,
                'verAplic' => $verAplic,
                'cStat' => $cStat,
                'xMotivo' => $xMotivo,
                'cUF' => $cUf
            ];

        }catch (Exception $e){
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            echo json_encode($json);
            $json['model'] = $document;
            return $json;
        }
    }
}

if (!function_exists('sendTelegram')){
    function sendTelegram(array $attr, string $messageId){
        $bot = new \TelegramBot\Api\BotApi(env('TELEGRAM_TOKEN'));
        $message = montaTitulo($attr, true);
        $newMessage = $bot->sendMessage(env('TELEGRAM_CHATID'), $message);
        $newMessageId = $newMessage->getMessageId();

        if ($messageId !== '0'){
            if ((String) $newMessageId !== $messageId){
                $bot->deleteMessage(env('TELEGRAM_CHATID'), $messageId);
            }
        }
        return (string) $newMessageId;
    }
}

if (!function_exists('montaTitulo')){
    function montaTitulo(array $data): string
    {
        $documento = $data['model'] == 55 ? 'NF-e' : 'NFC-e';
        $tipoAmbiente = $data['tpAmb'] == '1' ? 'Produção' : 'Homologação';
        return $title = 'SVRS ' .$documento.' - ' . $tipoAmbiente;
    };
}

if (!function_exists('sendDiscord')){
    function sendDiscord(array $attr)
    {
        $URL = $attr["cStat"] === 107 ? env('ERROR') : env('SUCCESS');

        $messageFactory = new MessageFactory();
        $embedMessage = $messageFactory->create('embed');
        $embedMessage->setUsername("SEFAZ");
        $embedMessage->setTitle(montaTitulo($attr));
        $embedMessage->setDescription($attr['xMotivo']);
        $embedMessage->setColor($attr["cStat"] === 107 ? 0xFF0000 : 0x00FF00);
        $embedMessage->setFooterText(date('d-m-y H:i:s'));

        $webhook = new DiscordWebhook($embedMessage);
        $webhook->setWebhookUrl($URL);
        $webhook->send();
    }
}
