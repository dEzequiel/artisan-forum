<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
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
            'data' => [
                'type' => 'community',
                'id' => $this->resource->getRouteKey(),
            'attributes' => [
                'community_id' => $this->resource->id,
                'name' => $this->resource->name,
                'description' => $this->resource->description
            ],
            'links' => [
                'self' => route('communities.show', $this->resource->id)]
            ]
        ];
    }

    public function withResponse($request, $response)
    {
        $response->withHeaders([
            'Content-Type' => "application/vnd.api+json"
        ]);

        return parent::withResponse($request, $response); // TODO: Change the autogenerated stub
    }
}
