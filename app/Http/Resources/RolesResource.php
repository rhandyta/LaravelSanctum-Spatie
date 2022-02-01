<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('d F, Y'),
            'roles_id' => $this->roles[0]->id,
            'roles_name' => $this->roles[0]->name,
            'roles_guard' => $this->roles[0]->guard_name,
            'permission_add' => $this->can('add'),
            'permission_edit' => $this->can('edit'),
            'permission_delete' => $this->can('delete'),
            'permission_view' => $this->can('view'),
        ];
    }
}
