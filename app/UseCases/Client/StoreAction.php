<?php


namespace App\UseCases\Client;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class StoreAction
{
    public function __invoke($request): Client
    {
        if ($request->filled('client_id')){
            $clientInstance = Client::query()->find($request->client_id);
        }else{
            $clientInstance = new Client;
        }

        $request = $this->generateCheck($request);
        $clientInstance->fill($request->all())->save();

        return $clientInstance;
    }

    private function generateCheck($request)
    {
        if ($request->filled('address_check') === false){
            $request->merge(['address_check' => 0]);
        }
        if ($request->filled('tel_check') === false){
            $request->merge(['tel_check' => 0]);
        }
        if ($request->filled('mobile_check') === false){
            $request->merge(['mobile_check' => 0]);
        }
        if ($request->filled('email_check') === false){
            $request->merge(['email_check' => 0]);
        }
        if ($request->filled('s_mobile_email_check') === false){
            $request->merge(['s_mobile_email_check' => 0]);
        }
        if ($request->filled('mobile_email_check') === false){
            $request->merge(['mobile_email_check' => 0]);
        }

        return $request;
    }
}