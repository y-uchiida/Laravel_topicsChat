<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Repositories\ImageRepository;

use Carbon\Carbon;

class ImageService
{
    protected $image_repository;

    public function __construct(ImageRepository $image_repo)
    {
        $this->image_repository = $image_repo;
    }

    /**
     * Create new image and put storage disk
     *
     * @param array $images
     * @param int $message_id
     *
     * @return Image $image
     */
    public function createNewImage(array $images, int $message_id)
    {
        DB::beginTransaction();
        try{
            foreach($images as $image){
                $path = Storage::disk('s3')->put('/', $image); /* AWSのS3バケットにアップロードを実行 */
                $data = [
                    'file_path' => $path,
                    'message_id' => $message_id
                ];
                $this->image_repository->create($data); /* DB へのレコードの作成はリポジトリ層で行う */
            }
        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
        DB::commit();
    }

    /*
     * セキュリティ対策のため、添付画像は外部アクセスできない形で保存されている
     * 画面表示ができるように、一時的なURLを生成して、それを利用する
     */
    public function createTemporaryUrl(String $file_path)
    {
        return Storage::disk('s3')->temporaryUrl($file_path, Carbon::now()->addDay());
    }
}
