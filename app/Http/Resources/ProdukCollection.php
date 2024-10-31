<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProdukCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        
        // KAMIS
        // return [
        //     'data' => $this->collection,
        //     'meta' => [
        //         'total' => $this->collection->count(),
        //     ],
        // ];

        // JUMAT
        // return [
        //     'data' => $this->collection,
        //     'pagination' => [
        //         'total' => $this->total(),
        //         'count' => $this->count(),
        //         'per_page' => $this->perPage(),
        //         'current_page' => $this->currentPage(),
        //         'total_pages' => $this->lastPage(),
        //         'next_page_url' => $this->nextPageUrl(),
        //         'prev_page_url' => $this->previousPageUrl(),
        //     ],
        // ];

        return [
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
            ],
        ];
    }
}
