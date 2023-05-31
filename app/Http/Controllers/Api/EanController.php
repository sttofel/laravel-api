<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ean;
use App\Repositories\EanRepository;
use Illuminate\Http\Request;
use NFePHP\Gtin\Gtin;
use NFePHP\Common\Certificate;

class EanController extends Controller
{
    protected $repository;

    public function __construct(EanRepository $EanRepository){
        $this->repository = $EanRepository;
    }

    public function findByEan(String $ean)
    {
        return $this->repository->searchEan($ean);
    }
}
