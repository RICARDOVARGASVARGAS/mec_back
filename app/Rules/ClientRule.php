<?php

namespace App\Rules;

use App\Models\Client;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ClientRule implements ValidationRule
{
    public $company_id, $client_id;

    public function __construct($company_id, $client_id)
    {
        $this->company_id = $company_id;
        $this->client_id = $client_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->client_id) {
            $client = Client::whereNot('id', $this->client_id)
                ->where('company_id', $this->company_id)
                ->where('document', $value)->first();
        } else {
            $client = Client::where('company_id', $this->company_id)->where('document', $value)->first();
        }

        if ($client) {
            $fail('El DNI ya existe.');
        }
    }
}
