<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    public function getStatus(){
        $status = [
            0 => "Verification Pending",
            1 => "Active",
            2 => "Blocked",
        ];
        return $status[$this->status];
    }
    
    public function getRole(){
        $role = [
            1 => "Admin",
            2 => "User",
        ];
        return $role[$this->userType];
    }

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
            'user_status' => $this->getStatus(),
            'status' => $this->status,
            'userType' => $this->userType,
            'role' => $this->getRole(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
