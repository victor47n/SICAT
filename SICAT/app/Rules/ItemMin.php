<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ItemMin implements Rule
{
    private $item;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            if ($item['amount'] == 0) {
                $this->item = DB::table('items')
                    ->select('name')
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
        return 'A quantidade do item '.$this->item->name.' precisa ser maior que 0';
    }
}
