<?php

namespace App\Http\Requests;

use App\Models\PlayerBlacklistEntry;
use App\Models\TetrioUser;
use Illuminate\Foundation\Http\FormRequest;

class PlayerBlacklistEntryCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tetrio_id' => 'required',
            'until' => 'date|nullable',
            'reason' => 'required|min:5'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tetrioUser = TetrioUser::updateOrCreateFromId($this->get('tetrio_id'));

            if ($tetrioUser == null) {
                $validator->errors()->add('tetrio_id', 'User does not exist');
            } else {
                if ($tetrioUser->isBlacklisted()) {
                    $validator->errors()->add('tetrio_id', 'User is already blacklisted');
                }
            }
        });
    }

    public function authorize()
    {
        return $this->user()->can('create', PlayerBlacklistEntry::class);
    }
}
