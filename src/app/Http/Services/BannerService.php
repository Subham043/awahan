<?php

namespace App\Http\Services;

use App\Models\Banner;
use App\Http\Resources\BannerCollection;
use App\Http\Requests\BannerCreatePostRequest;
use App\Http\Requests\BannerUpdatePostRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\FileService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class BannerService
{
    private $bannerModel;

    public function __construct(Banner $bannerModel)
    {
        $this->bannerModel = $bannerModel;
    }

    public function all(): Collection
    {
        return $this->bannerModel->all();
    }

    public function random(): Collection
    {
        return $this->bannerModel->inRandomOrder()->limit(4)->get();
    }

    public function pagination(Request $request): LengthAwarePaginator
    {
        return $this->bannerModel->orderBy('id', 'DESC')->paginate(10);
    }

    public function getById(Int $id): Banner
    {
        return $this->bannerModel->findOrFail($id);
    }

    public function geBannerResource(Banner $banner): BannerCollection
    {
        return BannerCollection::make($banner);
    }

    public function geBannerCollection($banner): AnonymousResourceCollection
    {
        return BannerCollection::collection($banner);
    }

    public function create(BannerCreatePostRequest $request) : Banner
    {
        $image = (new FileService)->save_file($request, 'image', 'public/upload/banner');
        return $this->bannerModel->create([
            ...$request->except('image'),
            'image' => $image,
        ]);
    }

    public function decryptId(String $id): Int
    {
        return Crypt::decryptString($id);
    }

    public function delete(String $id): Banner
    {
        $banner = $this->getById($this->decryptId($id));
        (new FileService)->delete_file('app/public/upload/banner/'.$banner->image);
        $banner->delete();
        return $banner;
    }

    public function update(BannerUpdatePostRequest $request, String $id) : Banner
    {
        $banner = $this->getById($this->decryptId($id));
        if($request->hasFile('image')){
            $image = (new FileService)->save_file($request, 'image', 'public/upload/banner');
            (new FileService)->delete_file('app/public/upload/banner/'.$banner->image);
            $banner->update([
                ...$request->except('image'),
                'image' => $image,
            ]);
        }else{
            $banner->update([
                ...$request->except('image'),
            ]);
        }
        return $banner;
    }

}
