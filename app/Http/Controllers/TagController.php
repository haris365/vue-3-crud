<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function getTags()
    {
        $tags = Tag::all()->toArray(); 
        return array_reverse($tags);

    }
}
