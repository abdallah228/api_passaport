<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id'=>$this->id,
          'title'=>$this->title,
          'body'=>$this->body,
          'user_id'=>$this->user_id,
        //  'user'=>[
        //    'id'=>$this->user->id,
        //  'name'=>$this->user->name,
        //  'email'=>$this->user->email,
        //  ],
        //another way by making new resource
        'user'=> new UserResource($this->user),
          'created'=>$this->created_at->diffForHumans(),
        ];
    }

    public function with($request)
    {
        return [
            'version'=>'2.1.0',
            'author name'=>'abdallah khalid rashid',
        ];
    }
  
}
