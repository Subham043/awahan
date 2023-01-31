<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    private $statuses = [
        0 => "Verification Pending",
        1 => "Active",
        2 => "Blocked",
    ];

    private $roles = [
        1 => "Admin",
        2 => "User",
    ];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => Crypt::encryptString($this->id),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_status' => $this->statuses[$this->status],
            'status' => $this->status,
            'userType' => $this->userType,
            'role' => $this->roles[$this->userType],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
