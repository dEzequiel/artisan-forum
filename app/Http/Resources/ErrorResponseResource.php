<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponseResource extends JsonResource
{
    public int $code;
    public ?string $message;

    public function __construct(int $code, ?string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => null,
        ];
    }
}
