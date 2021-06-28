<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;

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
        
        $works = Work::select(['file_id','title', 'img'])
            ->take($sum + $num)
            ->get();
        for ($i = $sum; $i < (count($works) < $sum + $num ? count($works) : $sum + $num); $i++) {
            array_push($result, [
                'fileId' => $works[$i]['file_id'],
                'title' => $works[$i]['title'],
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
        
        $work = new Work();
        $work->fill([
            'img' => $img,
            'title' => $title,
            'file_id' => $file->id,
        ]);
        $work->save();
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
            $title = Work::where('file_id', $fileId)
                        ->first()['title'];
            return json_encode(['isExists' => true, 'title' => $title, 'md' => $response->getBody()->getContents()]);
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
    public function edit($id)
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
    public function destroy($id)
    {
        //
    }
}
