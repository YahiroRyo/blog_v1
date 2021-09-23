<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Work;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $googleDrive = null;

    public function getDriveClient(): \Google_Service_Drive
    {
        $client = new \Google_Client();

        // サービスアカウント作成時にダウンロードしたJSONファイルの名前を「client_secret」変更し、configフォルダ内に設置
        $client->setAuthConfig(config_path('client_secret.json'));
        $client->setScopes(['https://www.googleapis.com/auth/drive']);

        return new \Google_Service_Drive($client);
    }

    public function __construct()
    {
        $this->googleDrive = $this->getDriveClient();
    }

    public function index(Request $request)
    {
        // $request->tag：タグ
        $result = [];
        $tag = $request->tag;

        // BlogとWork(tag付き)をtmpに代入
        $tmp = array_merge(
            Blog::select(['id', 'file_id', 'title', 'img'])
            ->orderBy('id', 'desc')
            ->with('blog_tag')
            ->get()
            ->toArray(),
            Work::select(['id', 'file_id', 'title', 'img'])
            ->orderBy('id', 'desc')
            ->with('work_tag')
            ->get()
            ->toArray(),
        );
        // $tagと同じtagのある配列のみに絞る
        $tmp = array_filter($tmp, function ($value) use ($tag) {
            $key = '';
            $is_exist_tag = false;
            if (array_key_exists('blog_tag', $value)) {
                $key = 'blog_tag';
            } elseif (array_key_exists('work_tag', $value)) {
                $key = 'work_tag';
            }
            for ($i = 0; $i < count($value[$key]); $i++) {
                if ($value[$key][$i]['tag'] == $tag) {
                    $is_exist_tag = true;
                }
            }

            return $is_exist_tag;
        });
        \Log::info($tmp);
        foreach ($tmp as &$v) {
            $key = '';
            $genre = '';
            if (array_key_exists('blog_tag', $v)) {
                $key = 'blog_tag';
                $genre = 'blog';
            } elseif (array_key_exists('work_tag', $v)) {
                $key = 'work_tag';
                $genre = 'work';
            }
            array_push($result, [
                'fileId' => $v['file_id'],
                'tags'   => array_map(
                    function ($tag) use ($genre) {
                        unset($tag[$genre == 'blog' ? 'blog_id' : 'work_id']);

                        return $tag['tag'];
                    },
                    $v[$key]
                ),
                'title' => $v['title'],
                'genre' => $genre,
                'img'   => $v['img'],
            ]);
        }

        return $result;
    }
}
