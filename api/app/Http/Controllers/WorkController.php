<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;
use App\Models\WorkTag;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
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

    public function __construct() {
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
        
        $works = Work::select(['id', 'file_id','title', 'img', 'updated_at'])
            ->orderBy('id', 'desc')
            ->take($sum + $num)
            ->with('work_tag')
            ->get()
            ->toArray();
        for ($i = $sum; $i < (count($works) < $sum + $num ? count($works) : $sum + $num); $i++) {
            array_push($result, [
                'fileId' => $works[$i]['file_id'],
                'title' => $works[$i]['title'],
                'tags' => array_map(
                    function($tag){
                        unset($tag['work_id']);
                        return $tag['tag'];
                    }, $works[$i]['work_tag']
                ),
                'update' => $works[$i]['updated_at'],
                'img' => $works[$i]['img'],
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
        // $request->tags   タグ
        // $request->img    画像URL
        // $request->md     マークダウン
        $title = $request->title;
        $tags = $request->tags;
        $img = $request->img;
        $md = $request->md;

        DB::beginTransaction();
        $file = $this->googleDrive->files->create(
            new \Google_Service_Drive_DriveFile([
                'name' => $title.'.md',
                'mimeType' => 'text/markdown',
                'driveId' => '1Y7nsnEz3gXbARJiRBxCWcMJXcADvtKVu',
                'parents' => ['1Y7nsnEz3gXbARJiRBxCWcMJXcADvtKVu'],
            ]),
            [
                'data' => $md,
                'fields' => 'id',
                'supportsAllDrives' => true,
            ]
        );
        try {
            $work = new Work();
            $work->fill([
                'img' => $img,
                'title' => $title,
                'file_id' => $file->id,
            ]);
            $work->save();
            foreach($tags as &$tag) {
                $workTag = new WorkTag();
                $workTag->fill([
                    'work_id' => $work->id,
                    'tag' => $tag,
                ]);
                $workTag->save();
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
        //
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
        if (Work::where('file_id', $fileId)->exists()) {
            $response = $this->googleDrive->files->get(
                $fileId,
                ['alt' => 'media'],
            );
            $work = Work::where('file_id', $fileId)
                        ->with('work_tag')
                        ->first()
                        ->toArray();
            return json_encode([
                'isExists' => true,
                'update' => $work['updated_at'],
                'title' => $work['title'],
                'img' => $work['img'],
                'md' => $response->getBody()->getContents(),
                'tags' => array_map(
                    function($tag) {
                        unset($tag['work_id']);
                        return $tag['tag'];
                    }, $work['work_tag'])
                ]);
        } else {
            return json_encode(['isExists' => false, 'title' => '', 'img' => '','md' => '', 'tags' => []]);
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
            $this->googleDrive->files->update($fileId, new \Google_Service_Drive_DriveFile, [
                'data' => $md,
                'mimeType' => 'text/markdown',
                'uploadType' => 'multipart',
            ]);

            $work = Work::where('file_id', $request->fileId)
                ->first();
            $work->fill([
                'title' => $title,
                'img' => $img,
                'md' => $md,
            ]);
            $work->save();
            
            $work_tag_where = WorkTag::where('work_id', $work->id);
            if ($work_tag_where->exists()) {
                $work_tag_where->delete();
            }
            foreach($tags as &$tag) {
                $work_tag = new WorkTag();
                $work_tag->fill([
                    'work_id' => $work->id,
                    'tag' => $tag,
                ]);
                $work_tag->save();
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
    public function update(Request $request, $id)
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
        $work_query_where = Work::where('file_id', $file_id);
        if ($work_query_where->exists()) {
            try {
                $work_query_where->delete();
                WorkTag::where('file_id', $file_id)->delete();
                $this->googleDrive->files->delete($file_id);
            } catch (\Exception $e) {
                DB::rollback();
            }
            DB::commit();
        } else {
            throw new \Exception("そのfileIdは存在しません");
        }
    }
}
