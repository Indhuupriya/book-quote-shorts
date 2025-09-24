<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index() {
        return Quote::orderBy('id')->get();
    }

    public function show(Quote $quote) {
        return $quote;
    }

    public function like(Quote $quote) {
        $quote->increment('likes');
        return response()->json(['id'=>$quote->id,'likes'=>$quote->likes]);
    }
}
