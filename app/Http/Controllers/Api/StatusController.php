<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\StatusRepository;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    protected $repository;

    public function __construct(StatusRepository $StatusRepository){
        $this->repository = $StatusRepository;
    }

    public function index($document){
        $this->repository->index($document);
    }
}
