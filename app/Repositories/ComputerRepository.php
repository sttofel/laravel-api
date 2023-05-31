<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Computer;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class ComputerRepository
{
    protected $entity;


    public function __construct(Computer $model)
    {
        $this->entity = $model;
    }

    public function getAllComputers(){
        return $this->entity->get();
    }

    public function getComputer(String $identity){
        $computer = $this->entity->findOrFail($identity);
        if (Carbon::now() > $computer->end_date){

        }
        return $this->entity->findOrFail($identity);
    }

    public function getComputerBySerial(String $serial){
        return $this->entity->where('serial', $serial)->first();
    }

    public function createComputer(array $attributes){
        return $this->entity->create([
                'reseller_id' => $attributes['reseller_id'],
                'customer_id' => $attributes['customer_id'],
                'serial' => $attributes['serial'],
                'start_date' => Carbon::now(),
                'end_date' => $attributes['end_date'],
                'review' => $attributes['review'],
            ]);
    }

    public function updateComputer(array $attributes, String $identity){
        $computer = $this->entity->findOrfail($identity);
        $computer->reseller_id = $attributes['reseller_id'];
        $computer->customer_id = $attributes['customer_id'];
        $computer->serial = $attributes['serial'];
        $computer->start_date = $attributes['start_date'];
        $computer->end_date = $attributes['end_date'];
        $computer->review = $attributes['review'];
        $status = $computer->save();
        return ['message' => $status, 'computer' => $computer];
    }

    public function deleteComputer(String $identity){
        $computer = $this->entity->findOrfail($identity);
        $status = $computer->delete();
        return ['message' => $status];
    }

}
