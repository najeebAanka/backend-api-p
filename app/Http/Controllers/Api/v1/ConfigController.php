<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarColor;
use App\Models\Content;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Fuel;
use App\Models\Job;
use App\Models\JobRequest;
use App\Models\Message;
use App\Models\Model;
use App\Models\News;
use App\Models\Partner;
use App\Models\Quote;
use App\Models\Review;
use App\Models\Status;
use App\Models\Team;
use App\Models\Banner;
use App\Models\Transmission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class ConfigController extends Controller
{
    public function news(Request $request)
    {

        $paginator = News::query();
        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;
        $paginator = $paginator->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'data' => \App\Resources\News::collection($paginator->items())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }


    public function quote(Request $request)
    {

        $min_year = (int)Carbon::parse(Car::min('year'))->format('Y');
        $max_year = (int)Carbon::parse(Car::max('year'))->format('Y');
        $years = [];
        $c = $min_year;
        while (true) {
            array_push($years, $c);
            if ($c == $max_year) {
                break;
            }
            $c++;
        }
        $data = [
            'brands' => \App\Resources\BrandFull::collection(Brand::get()),
            'years' => $years,
            'fuel' => \App\Resources\FuelFull::collection(Fuel::get())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }


    public function brands(Request $request)
    {

        $paginator = Brand::query();
        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;
        $paginator = $paginator->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'data' => \App\Resources\Brand::collection($paginator->items())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }

    public function reviews(Request $request)
    {

        $paginator = Review::query();
        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;
        $paginator = $paginator->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'data' => \App\Resources\Review::collection($paginator->items())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }

    public function partners(Request $request)
    {

        $paginator = Partner::query();
        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;
        $paginator = $paginator->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'data' => \App\Resources\Partner::collection($paginator->items())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }


    public function car($slug = null)
    {
        $data = Car::where('slug', $slug)->first();
        $data = $data ? \App\Resources\Car::make($data) : NULL;
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function cars(Request $request)
    {

        $paginator = Car::select('cars.*');
        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;

        if ($request->has('brands')) {
            $brands = explode(',', $request->get('brands'));
            if (sizeof($brands) > 0) {
                $paginator = $paginator->whereIn('brand_id', $brands);
            }
        }

        if ($request->has('text') && strlen($request->get('text')) > 2) {
            $text = $request->get('text');
            $paginator = $paginator->where(function ($q) use ($text) {
                return $q->where('cars.name', 'like', '%' . $text . '%')->
                orWhere('cars.title', 'like', '%' . $text . '%');
            });
        }

        if ($request->has('models')) {
            $models = explode(',', $request->get('models'));
            if (sizeof($models) > 0) {
                $paginator = $paginator->whereIn('model_id', $models);
            }
        }


        if ($request->has('min_year') && strlen($request->get('min_year')) > 3) {
            $paginator = $paginator->whereYear('year', '>=', $request->get('min_year'));
        }

        if ($request->has('max_year') && strlen($request->get('max_year')) > 3) {
            $paginator = $paginator->whereYear('year', '<=', $request->get('min_year'));
        }

        if ($request->has('status')) {
            $status = explode(',', $request->get('status'));
            if (sizeof($status) > 0) {
                $paginator = $paginator->whereIn('status', $status);
            }
        }

        if ($request->has('body_type')) {
            $body_type = explode(',', $request->get('body_type'));
            if (sizeof($body_type) > 0) {
                $paginator = $paginator->whereIn('body_type_id', $body_type);
            }
        }

        if ($request->has('engine')) {
            $engine = $request->get('engine');
            if (is_numeric($engine)) {
                $paginator = $paginator->where('engine', $engine);
            }
        }

        if ($request->has('seats')) {
            $seats = $request->get('seats');
            if (is_numeric($seats)) {
                $paginator = $paginator->where('seats', $seats);
            }
        }

        if ($request->has('source')) {
            $source = $request->get('source');
            if (is_numeric($source)) {
                $paginator = $paginator->where('source', $source);
            }
        }

        if ($request->has('fuel')) {
            $fuel = explode(',', $request->get('fuel'));
            if (sizeof($fuel) > 0) {
                $paginator = $paginator->
                join('cars_fuels', 'cars_fuels.car_id', '=', 'cars.id')->
                whereIn('cars_fuels.id', $fuel);
            }
        }

        if ($request->has('transmission')) {
            $transmission = explode(',', $request->get('transmission'));
            if (sizeof($transmission) > 0) {
                $paginator = $paginator->
                join('cars_transmissions', 'cars_transmissions.car_id', '=', 'cars.id')->
                whereIn('cars_transmissions.id', $transmission);
            }
        }

        if ($request->has('colors')) {
            $colors = explode(',', $request->get('colors'));
            if (sizeof($colors) > 0) {
                $paginator = $paginator->
                join('car_colors', 'car_colors.car_id', '=', 'cars.id')->
                whereIn('car_colors.color', $colors);
            }
        }


        $paginator = $paginator->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'data' => \App\Resources\CarBref::collection($paginator->items())
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }

    public function filters(Request $request)
    {

        $data = [
            'brands' => \App\Resources\Brand::collection(Brand::get()),
            'models' => \App\Resources\Model::collection(Model::get()),
            'body_types' => \App\Resources\BodyType::collection(BodyType::get()),
            'status' => \App\Resources\StatusFull::collection(Status::get()),
            'fuel' => \App\Resources\FuelFull::collection(Fuel::get()),
            'transmission' => \App\Resources\TransmissionFull::collection(Transmission::get()),
            'colors' => CarColor::select(['color', 'name'])->distinct()->get(),
            'min_year' => Carbon::parse(Car::min('year'))->format('Y'),
            'max_year' => Carbon::parse(Car::max('year'))->format('Y'),
        ];
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function home(Request $request)
    {
        $data = [];

        $premium = Status::where('name', 'Premium')->first();
        $used = Status::where('name', 'Used')->first();
        $new = Status::where('name', 'New')->first();
        $offers = Status::where('name', 'Offer')->first();

        $data['premium'] = \App\Resources\Car::collection(Car::where('status', $premium ? $premium->id : -1)->take(4)->orderBy('id', 'desc')->get());
        $data['new'] = \App\Resources\Car::collection(Car::where('status', $new ? $new->id : -1)->take(4)->orderBy('id', 'desc')->get());
        $data['used'] = \App\Resources\Car::collection(Car::where('status', $used ? $used->id : -1)->take(4)->orderBy('id', 'desc')->get());
//        $data['offers'] = \App\Resources\Car::collection(Car::where('status', $offers ? $offers->id : -1)->take(4)->orderBy('id', 'desc')->get());
        $data['offers'] = \App\Resources\Car::collection(
            Car::where('price', '<>', 'price_offer')->where('price_offer', '<>', NULL)->
            where('price_offer', '<>', 0)->take(4)->orderBy('id', 'desc')->get());
        $data['export'] = \App\Resources\Car::collection(Car::where('export', 1)->take(4)->orderBy('id', 'desc')->get());
        $data['popular'] = \App\Resources\Car::collection(Car::where('popular', 1)->take(8)->orderBy('id', 'desc')->get());
        $data['other_show_room'] = \App\Resources\Car::collection(Car::where('other_show_room', 1)->take(4)->orderBy('id', 'desc')->get());
        $data['last_news'] = \App\Resources\News::collection(News::take(4)->orderBy('id', 'desc')->get());

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function start(Request $request)
    {
        $mobile = setting('site.mobile');
        $whatsapp = setting('site.whatsapp');
        $facebook = setting('site.facebook');
        $instagram = setting('site.instagram');
        $youtube = setting('site.youtube');
        $email = setting('site.email');
        $tiktok = setting('site.tiktok');
        $linkedin = setting('site.linkedin');
        $twitter = setting('site.twitter');
        $vk_com = setting('site.vk_com');
        $days_work = setting('site.days_work');
        $times_work = setting('site.times_work');
        $off_day = setting('site.off_day');
        $support_1 = setting('site.support_1');
        $support_2 = setting('site.support_2');
        $banners = \App\Resources\Banner::collection(Banner::get());
        $faqs = \App\Resources\Faq::collection(Faq::orderBy('f_order', 'asc')->get()->translate(app()->getLocale(), 'fallbackLocale'));
        $jobs = \App\Resources\Job::collection(Job::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $team = \App\Resources\Team::collection(Team::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $countries = \App\Resources\Country::collection(Country::get()->translate(app()->getLocale(), 'fallbackLocale'));

        $data = [
            'banners' => $banners,
            'mobile' => $mobile,
            'whatsapp' => $whatsapp,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'youtube' => $youtube,
            'email' => $email,
            'tiktok' => $tiktok,
            'linkedin' => $linkedin,
            'twitter' => $twitter,
            'vk_com' => $vk_com,
            'days_work' => $days_work,
            'times_work' => $times_work,
            'off_day' => $off_day,
            'support_1' => $support_1,
            'support_2' => $support_2,
            'team' => $team,
            'faqs' => $faqs,
            'jobs' => $jobs,
            'countries' => $countries,
        ];

        $contents = \App\Resources\Content::collection(Content::get()->translate(app()->getLocale(), 'fallbackLocale'));
        foreach ($contents as $content) {
            $data[$content->code] = $content;
        }
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }


    public function quoteSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|exists:countries,id',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'feul_id' => 'required|exists:fuels,id',
            'year' => 'required|string',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $q = new Quote();
        $q->name = $request->get('name');
        $q->phone = $request->get('phone');
        $q->email = $request->get('email');
        $q->country = $request->get('country');
        $q->brand_id = $request->get('brand_id');
        $q->model_id = $request->get('model_id');
        $q->year = $request->get('year');
        $q->feul_id = $request->get('feul_id');
        $q->message = $request->get('message');
        $q->save();

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }


    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|exists:countries,id',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        Message::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'country' => $request->country,
            'message' => $request->message
        ]);


        return parent::sendSuccess(trans('messages.Message Sent!'), null);

    }


    public function jobRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
//            'job_id' => 'required|exists:jobs,id',
            'cv' => 'required|mimes:pdf|max:10000'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $cv = '';
        if ($request->hasFile('cv')) {
            $slug = 'job-requests';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->
            where('field', 'cv')->
            first();
            $cv = (new File($request, $slug, $row, $row->details))->handle();
        }


        JobRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'job_id' => $request->has('job_id') ? $request->get('job_id') : null,
            'cv' => $cv
        ]);

        return parent::sendSuccess(trans('messages.Job Request Sent!'), null);
    }


    public function addCarColor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
            'color' => 'required|string',
            'image' => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $image = '';
        if ($request->hasFile('image')) {
            $slug = 'car-colors';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->
            where('field', 'image')->
            first();
            $image = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $ci = new CarColor();
        $ci->car_id = $request->car_id;
        $ci->color = $request->color;
        $ci->image = $image;
        $ci->save();

        return redirect()->back()->with([
            'message' => "Added Successfully!",
            'alert-type' => 'success',
        ]);
    }

    public function removeCarColor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        CarColor::where([
            'id' => $request->id,
            'car_id' => $request->car_id,
        ])->delete();

        return redirect()->back()->with([
            'message' => "Removed Successfully!",
            'alert-type' => 'success',
        ]);
    }
}
