<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $request->num：取得する数
        // $request->sum：取得した数
        $result = [];
        $num = intval($request->num);
        $sum = intval($request->sum);

        $blogs = Blog::select(['id', 'file_id', 'title', 'img', 'updated_at'])
            ->orderBy('id', 'desc')
            ->take($sum + $num)
            ->with('blog_tag')
            ->get()
            ->toArray();
        for ($i = $sum; $i < (count($blogs) < $sum + $num ? count($blogs) : $sum + $num); $i++) {
            array_push($result, [
                'fileId' => $blogs[$i]['file_id'],
                'tags'   => array_map(
                    function ($tag) {
                        unset($tag['blog_id']);

                        return $tag['tag'];
                    },
                    $blogs[$i]['blog_tag']
                ),
                'title'  => $blogs[$i]['title'],
                'update' => $blogs[$i]['updated_at'],
                'img'    => $blogs[$i]['img'],
            ]);
        }

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $request->title  タイトル
        // $request->img    画像URL
        // $request->md     マークダウン
        $title = $request->title;
        $tags = $request->tags;
        $img = $request->img;
        $md = $request->md;

        DB::beginTransaction();
        $file = $this->googleDrive->files->create(
            new \Google_Service_Drive_DriveFile([
                'name'     => $title.'.md',
                'mimeType' => 'text/markdown',
                'driveId'  => '1Y7nsnEz3gXbARJiRBxCWcMJXcADvtKVu',
                'parents'  => ['1Y7nsnEz3gXbARJiRBxCWcMJXcADvtKVu'],
            ]),
            [
                'data'              => $md,
                'fields'            => 'id',
                'supportsAllDrives' => true,
            ]
        );

        try {
            $blog = new Blog();
            $blog->fill([
                'img'     => $img,
                'title'   => $title,
                'file_id' => $file->id,
            ]);
            $blog->save();
            foreach ($tags as &$tag) {
                $blogTag = new BlogTag();
                $blogTag->fill([
                    'blog_id' => $blog->id,
                    'tag'     => $tag,
                ]);
                $blogTag->save();
            }
        } catch (Exception $e) {
            DB::rollback();
        }
        DB::commit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $request->fileId: ファイルID
        $fileId = $request->fileId;
        if (Blog::where('file_id', $fileId)->exists()) {
            $response = $this->googleDrive->files->get(
                $fileId,
                ['alt' => 'media'],
            );
            $blog = Blog::where('file_id', $fileId)
                        ->with('blog_tag')
                        ->first()
                        ->toArray();

            return json_encode([
                'isExists' => true,
                'update'   => $blog['updated_at'],
                'title'    => $blog['title'],
                'img'      => $blog['img'],
                'md'       => $response->getBody()->getContents(),
                'tags'     => array_map(
                    function ($tag) {
                        unset($tag['blog_id']);

                        return $tag['tag'];
                    },
                    $blog['blog_tag']
                ),
            ]);
        } else {
            return json_encode(['isExists' => false, 'title' => '', 'img' => '', 'md' => '', 'tags' => []]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // $request->fileId ファイルID
        // $request->title  タイトル
        // $request->tags   タグ
        // $request->img    画像URL
        // $request->md     マークダウン
        $fileId = $request->fileId;
        $title = $request->title;
        $tags = $request->tags;
        $img = $request->img;
        $md = $request->md;
        DB::beginTransaction();

        try {
            $file = $this->googleDrive->files->get($fileId);
            $this->googleDrive->files->update($fileId, new \Google_Service_Drive_DriveFile(), [
                'data'       => $md,
                'mimeType'   => 'text/markdown',
                'uploadType' => 'multipart',
            ]);

            $blog = Blog::where('file_id', $request->fileId)
                ->first();
            $blog->fill([
                'title' => $title,
                'img'   => $img,
                'md'    => $md,
            ]);
            $blog->save();

            $blog_tag_where = BlogTag::where('blog_id', $blog->id);
            if ($blog_tag_where->exists()) {
                $blog_tag_where->delete();
            }
            foreach ($tags as &$tag) {
                $blog_tag = new BlogTag();
                $blog_tag->fill([
                    'blog_id' => $blog->id,
                    'tag'     => $tag,
                ]);
                $blog_tag->save();
            }
        } catch (\Exception $e) {
            DB::rollback();

            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request): void
    {
        // $request->fileId
        $file_id = $request->fileId;
        DB::beginTransaction();
        $blog_query_where = Blog::where('file_id', $file_id);
        if ($blog_query_where->exists()) {
            try {
                $blog_id = $blog_query_where->delete();
                BlogTag::where('blog_id', $blog_id)->delete();
                $this->googleDrive->files->delete($file_id);
            } catch (Exception $e) {
                DB::rollback();
            }
            DB::commit();
        } else {
            throw new \Exception('そのfileIdは存在しません');
        }
    }
}
