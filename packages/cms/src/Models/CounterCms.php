<?php
///**
// * Created by PhpStorm.
// * User: brcyber
// * Date: 12/05/16
// * Time: 20:18
// */
//
//namespace Cms\Models;
//
//use Illuminate\Support\Facades\Log;
//use Kryptonit3\Counter\Models\Page;
//use Kryptonit3\Counter\Models\Visitor;
//use Rhumsaa\Uuid\Uuid;
//use Jaybizzle\CrawlerDetect\CrawlerDetect;
//use Carbon\Carbon;
//use DB;
//use Cookie;
//
//use Kryptonit3\Counter\Counter;
//
//
//class CounterCms extends Counter
//{
//    static public function dateRangeHits($start, $end)
//    {
//        $prefix = config('database.connections.' . config('database.default') . '.prefix');
//
//        $hits = DB::table($prefix . 'kryptonit3_counter_page_visitor')
//            ->where([
//                ['created_at', '>=', $start],
//                ['created_at', '<=', $end],                
//            ])->count();
//
//        
//
//        //Log::info($start);
//
//        return number_format($hits);
//    }
//
//    static public function dateRangeHitsPage($identifier, $start, $end)
//    {
//
//        $page = self::pageId($identifier, null);
//
//        return $page;
//
//        $prefix = config('database.connections.' . config('database.default') . '.prefix');
//
//        DB::connection()->enableQueryLog();
//        $queries = DB::getQueryLog();
//
//        $hits = DB::table($prefix . 'kryptonit3_counter_page_visitor')
//            ->join('kryptonit3_counter_page', function ($join) use ($page) {
//                $join->on('kryptonit3_counter_page.id', '=', 'kryptonit3_counter_page_visitor.page_id')
//                    ->where('kryptonit3_counter_page.page', '=', $page);
//            })
//            ->where([
//                ['created_at', '>=', $start],
//                ['created_at', '<=', $end]
//            ])->count();
//     
//        $queries = DB::getQueryLog();
//        Log::info($queries);
//
//        return number_format($hits);
//    }
//    private static function pageId($identifier, $id = null)
//    {
//        $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $identifier);
//        if ($id) {
//            $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $identifier . '-' . $id);
//        }
//
//        return $uuid5;
//    }
//
//}