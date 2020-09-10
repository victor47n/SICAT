<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ItemStock implements Rule
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    private $item_stock;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $item) {
            $response = DB::table('items')
                ->select('id')
                ->where('id', '=', $item['item_id'])
                ->where('amount', '>=', $item['amount'])
                ->first();

            if($response == NULL || $response == "") {
                $this->item_stock = DB::table('items')
                             ->select('name', 'amount')
                             ->where('id', '=', $item['item_id'])
                             ->first();
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Quantidade inválida de '.$this->item_stock->name.'. O quantidade máxima para empréstimo é de '.$this->item_stock->amount.' itens.';
    }
}
