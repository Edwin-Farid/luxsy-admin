<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $success, $messages;

    public function __construct($success, $messages, $data)
    {
        parent::__construct($data);
        $this->success = $success;
        $this->messages = $messages;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->messages,
            'data' => $this->resource
        ];
    }
}
