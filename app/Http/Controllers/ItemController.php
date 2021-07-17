<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    public function index()
    {
        return Item::all();
    }

    public function show($name)
    {
        return Item::where('name', $name)->firstOrFail();
    }

    public function store(Request $request)
    {
        return Item::create($request->all());
    }

    public function upload(Request $request)
    {
        $path = $request->file('items');
        $content = File::get($path);
        $items = json_decode($content);
        $entries = array_map(fn ($n) => [
            'name' => $n->Name,
            'shortName' => $n->ShortName_EN,
        ], $items);

        return $items;
        return $entries;
        return Item::create($entries);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());

        return $item;
    }

    public function delete(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return 204;
    }
}
