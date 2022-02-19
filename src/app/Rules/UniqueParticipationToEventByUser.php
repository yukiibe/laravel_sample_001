<?php

namespace App\Rules;

use App\Models\Participation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class UniqueParticipationToEventByUser implements Rule
{
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
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
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
        $user_id = data_get($this->data, 'user_id');
        $count = Participation::where('user_id', $user_id)->where('event_id', $value)->count();

        return $count == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Can not participate the event by the same user.';
    }
}
