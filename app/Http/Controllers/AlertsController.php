<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;

class AlertsController extends Controller
{
    public function __construct()
    {
        $user = \Auth::user();
        if (!$user->is_admin) {
            return redirect('/')->send();
        }
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::whereAlerted(true)->paginate(20);
        return view('welcome', [
            'items' => $items,
        ]);
    }
    
    public function alert()
    {
        $itemCode = request()->itemCode;

        // itemCode から商品を検索
        $client = new \RakutenRws_Client();
        $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));
        $rws_response = $client->execute('IchibaItemSearch', [
            'itemCode' => $itemCode,
        ]);
        $rws_item = $rws_response->getData()['Items'][0]['Item'];

        // Item 保存 or 検索（見つかると作成せずにそのインスタンスを取得する）
        $item = Item::firstOrCreate([
            'code' => $rws_item['itemCode'],
            'name' => $rws_item['itemName'],
            'url' => $rws_item['itemUrl'],
            // 画像の URL の最後に ?_ex=128x128 とついてサイズが決められてしまうので取り除く
            'image_url' => str_replace('?_ex=128x128', '', $rws_item['mediumImageUrls'][0]['imageUrl']),
        ]);

        $item->alerted = true;
        $item->save();

        return redirect()->back();
    }
    
    public function dont_alert()
    {
        $itemCode = request()->itemCode;
        // whereCode($code) === where('code', '=', $code)
        $item = Item::whereCode($itemCode)->first(); // code列を作成すると自動的に whereCode という構文が使えるようになる
        $item->alerted = false;
        $item->save();
        
        return redirect()->back();
    }
}