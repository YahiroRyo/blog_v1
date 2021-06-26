<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blog;

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
        
        $blogs = Blog::select(['file_id','title', 'img'])
            ->take($sum + $num)
            ->get();
        for ($i = $sum; $i < (count($blogs) < $sum + $num ? count($blogs) : $sum + $num); $i++) {
            array_push($result, [
                'fileId' => $blogs[$i]['file_id'],
                'title' => $blogs[$i]['title'],
                'img' => $blogs[$i]['img'],
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
        $img = $request->img;
        $md = $request->md;

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
        
        $blog = new Blog();
        $blog->fill([
            'img' => $img,
            'title' => $title,
            'file_id' => $file->id,
        ]);
        $blog->save();
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
            return json_encode(['isExists' => true, 'md' => $response->getBody()->getContents()]);
        } else {
            return json_encode(['isExists' => false, 'md' => '']);
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
        //
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
    public function destroy($id)
    {
        //
    }
}
