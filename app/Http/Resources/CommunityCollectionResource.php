<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommunityCollectionResource extends ResourceCollection
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
            'data' => $this->collection,
            'links' => [
                'self' => route('api.v1.community.getAll'),
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->withHeaders([
            'Content-Type' => "application/vnd.api+json"
        ]);

        return parent::withResponse($request, $response);
    }
}
