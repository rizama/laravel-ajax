<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    /**
     * Index
     * @return void
     */
    public function index()
    {
        $items = Item::all();
        return view('list', compact('items'));
    }

    /**
     * create function
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $item = new Item;

        $item->item = $request->item;
        $item->save();

        return "Done";
    }

    public function update()
    {
        $item = Item::findOrFail(request()->id);
        $item->item = request()->item;
        $item->save();
        return 'Updated';
    }

    public function destroy()
    {
        $item = Item::findOrFail(request()->id);
        $item->delete();
        return 'Deleted';
    }

    public function search()
    {
        $term = request()->term;
        $items = Item::where('item', 'LIKE', '%' . $term . '%')->get();
        if (count($items) == 0) {
            return $searchResult = [
                'Item Not Found'
            ];
        }

        foreach ($items as $key => $value) {
            $searchResult[] = $value->item;
        }

        return $searchResult;
    }
}
