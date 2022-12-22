<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Term;
use App\Models\Taxonomy;
use App\Models\MatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function index(Request $request) {
        $posts = Post::type('at_biz_dir')->hasMetaLike('_admin_category_select', '%"11"%')->get();
        // $posts = Post::published()->get();
        return response()->json(['post'=>$posts]);
    }
    public function search(Request $request) {
        return view('search');
    }
    public function get_category() {
        $category = Taxonomy::where('taxonomy', '=', 'at_biz_dir-category')->get();

        return response()->json([
            'success'=>true,
            'data'=>$category
        ]);
    }
    public function search_list(Request $request) {
        // $givenLat = 37.7685329;
        // $givenLng = -97.2113605;
        // $newLat = 38.7685329;
        // $newLng = -98.2113605;
        // $distance = sqrt(POW((69.1 * ($newLat - $givenLat)),2) + POW((69.1 * ($givenLng - $newLng) * cos($newLng / 57.3)),2));
        // return response()->json(['data'=>$distance]);
        $lists = Post::type('at_biz_dir')->where('post_status', '=', 'publish')
        // ->hasMetaLike('_admin_category_select', '%"'.$request->category.'"%')
        ->leftJoin(DB::raw('(SELECT post_id, status, MAX(created_at) AS c_at FROM oun_match_list GROUP BY post_id) oun_match_list'), function($join) {
            $join->on('posts.id', '=', 'match_list.post_id');
        })
        // ->orderBy('match_list.status', 'asc')
        ->orderBy('match_list.c_at', 'asc')
        ->select('posts.*', 'match_list.c_at', 'match_list.status as match_status')
        ->get();
        // return response()->json([
        //     'data'=>$lists
        // ]);
        if (count($lists) > 0) {
            $matchList = $this->getNearestUsers($request->location, $lists);
            if (count($matchList) > 0) {
                // if ( $matchList[0]['match_status'] === null || $matchList[0]['match_status'] === 0) {
                    $matchId = MatchList::insertGetId([
                        'post_id'=>$matchList[0]['ID'],
                        'fname'=>$request->fname,
                        'lname'=>$request->lname,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'zipcode'=>$request->zipcode
                    ]);
                    $matchList[0]['email'] = $matchList[0]->meta->_email;               
                    $matchList[0]['zipcode'] = $matchList[0]->meta->_zip;               
                    return response()->json([
                        'success'=>true,
                        'list'=>$matchList[0],
                        'data'=>$matchId
                    ]);
                // }
            }
        }            
        return response()->json([
            'success'=>false,
            'message'=>'no data'
        ]);
    }
    function getNearestUsers($location,$lists)
    {
        $matchList = array();
        // $post_ids = array();
        $givenLat = $location['lat'];
        $givenLng = $location['lng'];
       foreach($lists as $r)
       {
          $distance = sqrt(POW((69.1 * ($r->meta->_manual_lat - $givenLat)),2) + POW((69.1 * ($givenLng - $r->meta->_manual_lng) * cos($r->meta->_manual_lng / 57.3)),2));
          if($distance<=50)  //50 miles
           {
                // array_push($post_ids, $r['ID']);
                array_push($matchList, $r);
           }
       }
       return $matchList;
    }
}

?>