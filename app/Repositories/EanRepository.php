<?php

namespace App\Repositories;

use App\Models\Ean;
use Illuminate\Support\Facades\Cache;
use NFePHP\Gtin\Gtin;
use NFePHP\Common\Certificate;

class  EanRepository {

    protected $entity;

    public function __construct(Ean $model){
        $this->entity = $model;
    }


    public function searchEan(String $ean)
    {
        $expiration = 60; // minutes
        $key = 'gtin_'.$ean;

        return Cache::remember($key, $expiration, function () use ($ean){
            $search = $this->entity->where('ean', $ean)->first();

            if (empty($search)){
                $ws = $this->Consulta($ean);

                if ($ws["found"] == 1){
                    $this->entity->create([
                        'ean' => $ean,
                        'product' => $ws["product"],
                        'ncm' => $ws["ncm"],
                        'cest' => $ws["cest"],
                        'found' => $ws["found"]
                    ]);
                    return $ws;
                }
            }else{
                return $search;
            }
        });
    }

    private function Consulta(String $ean)
    {
        $searchVal = array("&#45;");
        $replaceVal = array("-");

        $cert = Certificate::readPfx(file_get_contents(public_path('assets/certificate/' . env('CERT'))), env('CERT_PW'));
        $response = Gtin::check($ean, $cert)->consulta();

        if (!empty($response) && $response->sucesso && $response->motivo == 'Dados encontrados.'){
            $response->xProd = str_replace($searchVal, $replaceVal, $response->xProd);
            return [
                'ean' => $ean,
                'product' => $response->xProd,
                'ncm' => $response->NCM,
                'cest' => $response->CEST,
                'found' => $response->sucesso
            ];
        }else{
            return [
                'ean' => $ean,
                'product' => null,
                'ncm' => null,
                'cest' => null,
                'found' => 0
            ];
        }
    }
}
