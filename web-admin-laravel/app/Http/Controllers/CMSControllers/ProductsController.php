<?php

namespace App\Http\Controllers\CMSControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Product;
use App\Models\CMSModels\ProductAttributeValue;
use App\Http\Requests\CMS\Products\CreateRequest;
use App\Http\Requests\CMS\Products\MediaRequest;
use App\Http\Requests\CMS\Products\AttributesRequest;
use App\Http\Resources\CMS\ProductsResource;
use App\Http\Controllers\CMSControllers\MediaController;
use Auth;
use Excel;
use Str;
use App\Exports\CMS\ProductsExport;
use App\Http\Requests\CMS\Products\UpdateRequest;
use App\Imports\CMS\ProductsImport;
use App\Models\CMSModels\Media;
use App\Models\CMSModels\Setting;
use DB;
use PDF;
use ZipArchive;

class ProductsController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:products.index,guard:api');
        $this->middleware('permission:products.create,guard:api', ['only' => ['store']]);
        $this->middleware('permission:products.update,guard:api', ['only' => ['update', 'updateMedia']]);
        $this->middleware('permission:products.delete,guard:api', ['only' => ['destroy']]);
        $this->middleware('permission:products.update|products.is_active,guard:api', ['only' => ['updateStatus']]);
    }

    /********* Getter For Pagination, Searching And Sorting  ***********/
    public function getter($req = null, $export = null)
    {
        if ($req != null) {
            $products = Product::withAll()->with('variants');
            if ($req->vendor_id && $req->vendor_id != null) {
                $products = $products->where('vendor_id', $req->vendor_id);
            }
            if ($req->column && $req->column != null && $req->search && $req->search != null) {
                if ($req->column == 'name') {
                    $products = $products->whereLike($req->column . '->' . app()->getLocale(), $req->search);
                } else {
                    $products = $products->whereLike($req->column, $req->search);
                }
            } else if ($req->search && $req->search != null) {
                $products = $products->whereLike(['name->' . app()->getLocale()], $req->search);
            }
            if ($req->sort != null && $req->sort["field"] != null && $req->sort["type"] != null) {
                if ($req->sort["field"] == 'name') {
                    $locale = app()->getLocale();
                    $attribute = $req->sort['field'] . '->' . "'$.$locale'";
                    $products = $products->OrderBy(DB::raw("lower($attribute)"), $req->sort["type"]);
                } else {
                    $products = $products->OrderBy($req->sort["field"], $req->sort["type"]);
                }
            } else {
                $products = $products->OrderBy('id', 'desc');
            }
            if ($export != null) { // for export do not paginate
                $products = $products->get();
                return $products;
            }
            $totalProducts = $products->count();
            if ($req->perPage == -1) {
                $products = $products->paginate(0);
            } else {
                $products = $products->paginate($req->perPage);
            }
            $products = ProductsResource::collection($products)->response()->getData(true);
            return $products;
        }

        $products = ProductsResource::collection(Product::withAll()->with('variants')->orderBy('id', 'desc')->paginate(10))->response()->getData(true);
        return $products;
    }

    /********* FETCH ALL Products ***********/
    public function index()
    {

        $arrayName = array('products' => $this->getter());
        return response($arrayName);
    }

    /********* Export PDF , CSV And Excel  **********/
    public function export(Request $request)
    {
        $products = $this->getter($request, "export");
        if ($request->export == 'pdf') {
            $allSettings = Setting::where('name', 'web_logo_image_id')->first();
            $logo = Media::find((int)$allSettings->value);
            $new_logo = str_replace("/api/", "", $logo->original_media_path);
            $data['general'] = [
                'currentDate' => date("Y-m-d"),
                'fileName' => "Products",
                'reportName' => "Products",
                'logo' => $new_logo,
            ];
            $data['tableHeaders'] = ["Sr#", "Name", "Manufacturer", "Price", "Product Type", "Status"];
            $data['tableData'] = [];
            foreach ($products as $key => $product) {
                $product_name = $product->name;
                if ($product->product_type == 1) {
                    $product_type = 'Simple';
                    $product_price =  get_display_price($product->price);
                } else {
                    $product_type = 'Variable';
                    $product_price =  get_display_price($product->variants->min('price'));
                }
                if (isset($product->flash_sale)) {
                    $product_name = $product->name . " (Flash Sale)";
                }
                if (isset($product->special_sale)) {
                    $product_name = $product->name . " (Special Sale)";
                }
                if ($product->is_active == 1) {
                    $is_active = "Active";
                } else {
                    $is_active = "Inactive";
                }
                if ($product->product_type == 1) {
                    $product_type = "Simple";
                } else {
                    $product_type = "Variable";
                }

                $result = [++$key,  $product_name, $product->manufacturer->name, $product_price, $product_type, $is_active];
                $data['tableData'][] = $result;
            }
            $pdf = PDF::loadView('pdf.pages', $data);
            return $pdf->setPaper('A4', 'potrait')->download('product.pdf');
        }
        $filename = "products." . $request->export;
        return Excel::download(new ProductsExport($products), $filename);
    }

    /********* FILTER Products FOR Search ***********/
    public function filter(Request $request)
    {
        return response()->json(["state" => "success", "message" => trans('messages.response.products.filter_success'), "products" => $this->getter($request)]);
    }

    /********* ADD NEW Product ***********/
    public function store(CreateRequest $request)
    {
        $default_language = defaultLanguage();
        $name = $request->name;
        $name = $name[$default_language->code] . ' ' . $request->sku;
        $slug = Str::slug($name);
        $request->merge(["slug" => $slug]);
        //Generating slug
        $allSettings = allSettings();
        $data = $request->except(['flash_sale', 'special_sale', 'categories', 'related_products']);
        // dd($data);
        $user = Auth::user();
        $guard = getGuard();
        if ($guard == "vendor") {
            if ((int)$allSettings['is_multi_vendor'] == 1) {
                $product = $user->products()->create($data);
            }
        } else if ($guard == "admin") {
            if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                if ((int)$allSettings['is_multi_vendor'] == 1) {
                    if ($data['vendor_id'] == null) {
                        // $data['vendor_id'] = 1;
                        $product = Product::create($data);
                    } else {
                        $product = Product::create($data);
                    }
                } else {
                    $data['vendor_id'] = 1;
                    $product = Product::create($data);
                }
            }
        }
        if ($product) {
            if ($request->flash_sale["exists"]) {
                $product->flash_sale()->create($request->flash_sale);
            }
            if ($request->special_sale["exists"]) {
                $product->special_sale()->create($request->special_sale);
            }
            if ($request->related_products) {
                $product->related_products()->attach($request->related_products);
            }
            $product->categories()->attach($request->categories);
        }
        $product = new ProductsResource($product);
        return response(["message" => trans('messages.response.products.create_success'), 'product' => $product]);
    }

    /********* View RECORD TO EDIT Or Display ***********/
    public function show($product)
    {
        $product = Product::withAll()->withAllDetail()->with('related_products_without_all')->find($product);
        return new ProductsResource($product);
    }

    /********* UPDATE Product ***********/
    public function update(UpdateRequest $request, Product $product)
    {
        //Generating slug
        $default_language = defaultLanguage();

        $allSettings = allSettings();
        $data = $request->except(['flash_sale', 'special_sale', 'categories', 'related_products']);
        if ((int)$allSettings['is_multi_vendor'] == 0) {
            $data['vendor_id'] = 1;
        }
        $name = $request->name;
        $name = $name[$default_language->code] . ' ' . $request->sku;
        $slug = Str::slug($name);
        $data["slug"] = $slug;
        $product->update($data);

        $flash_data = $request->flash_sale;
        unset($flash_data['exists']);
        $special_data = $request->special_sale;
        unset($special_data['exists']);

        if ($product->flash_sale && $request->flash_sale["exists"]) {
            $product->flash_sale()->update($flash_data);
        } else if (!$product->flash_sale && $request->flash_sale["exists"]) {
            $product->flash_sale()->create($flash_data);
        } else {
            $product->flash_sale()->delete();
        }
        if ($product->special_sale && $request->special_sale["exists"]) {
            $product->special_sale()->update($special_data);
        } else if (!$product->special_sale && $request->special_sale["exists"]) {
            $product->special_sale()->create($special_data);
        } else {
            $product->special_sale()->delete();
        }
        $product->related_products()->sync($request->related_products);

        $product->categories()->sync($request->categories);

        return response(["message" => trans('messages.response.products.update_success')]);
    }

    /********* UPDATE Product Media***********/
    public function updateMedia(MediaRequest $request, Product $product)
    {
        $product->media()->detach();
        foreach ($request->media_array as $key => $media) {
            $additional_columns = [];
            $additional_columns['sort_order'] = $key;
            $additional_columns['description'] = $media['description'];
            $additional_columns['alt_text'] = $media['alt_text'];
            $product->media()->attach($media['media_id'], $additional_columns);
        }
        // dd($product->media);
        $message = trans('messages.response.products.update_success');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }

    /********* UPDATE Product Attributes***********/
    public function updateAttribute(AttributesRequest $request, Product $product)
    {
        $default_language = defaultLanguage();
        $attributes = collect($request['attributes']);
        $attribute_ids = $attributes->pluck('id');
        ProductAttributeValue::where('product_id', $product->id)->whereNotIn('attribute_id', $attribute_ids)->delete();
        $product->attributes()->sync($attribute_ids);
        foreach ($attributes as $attribute) {
            $att = $product->attributes()->where('attributes.id', $attribute['id'])->first();
            $value_ids = collect($attribute['values'])->pluck('id');
            $att->values()->where('product_id', $product->id)->whereNotIn('id', $value_ids)->delete();
            foreach ($attribute['values'] as $value) {
                if (isset($value['id'])) {
                    $att->values()->where('id', $value['id'])->update(['name' => $value['value']]);
                } else {
                    $slug = $value['slug'];
                    $att->values()->create(['product_id' => $product->id, 'name' => $value['value'], 'slug' => $slug]);
                }
            }
        }
        $combinations = collect($request['combinations']);
        $combination_variants = $combinations->pluck('variant');
        $product->variants()->whereNotIn('variant', $combination_variants)->delete();
        foreach ($combinations as $combination) {
            $variant = $product->variants()->where('variant', $combination['variant'])->first();
            if ($variant) {
                $variant->update([
                    'name_combination' => $combination['name_combination'],
                    'variant' => $combination['variant'],
                    'price' => $combination['price'],
                    'sku' => $combination['sku'],
                    'stock' => $combination['stock']
                ]);
            } else {
                $product->variants()->create([
                    'name_combination' => $combination['name_combination'],
                    'variant' => $combination['variant'],
                    'price' => $combination['price'],
                    'sku' => $combination['sku'],
                    'stock' => $combination['stock']
                ]);
            }
        }
        if (count($product->variants) > 0) {
            $product->update([
                'is_active' => $request->is_active
            ]);
        }
        $product = Product::withAll()->find($product->id);
        return response(["message" => trans('messages.response.products.update_success'), 'product' => new ProductsResource($product)]);
    }

    /********* Delete Product Attribute***********/
    public function deleteAttribute(Product $product, $combination_id)
    {
        $product->attributes()->detach($combination_id);
        $product = Product::withAll()->find($product->id);
        return response(["message" => trans('messages.response.products.update_success'), 'product' => new ProductsResource($product)]);
    }

    /********* UPDATE Product Status***********/
    public function updateStatus(Request $request, Product $product)
    {
        $product->update([
            'is_active' => $product->is_active == 1 ? 0 : 1
        ]);
        return response()->json(["state" => "success", "message" =>  trans('messages.response.products.update_status_success'), "products" => $this->getter($request)]);
    }

    /********* DELETE LANGUAGE ***********/
    public function destroy(Request $request, Product $product)
    {
        $product->related_products()->detach();

        if($product->media){
            $media = new MediaController();
            foreach($product->media->pluck('id') as $id){
                $media->trashMedia($id);
            }
        }

        $product->delete();
        return response()->json(["state" => "success", "message" =>  trans('messages.response.products.delete_success'), "products" => $this->getter($request)]);
    }
    public function filterVendorProducts(Request $request)
    {
        return response()->json(["state" => "success", "message" =>  trans('messages.response.products.update_status_success'), "products" => $this->getter($request)]);
    }
    public function importData(Request $request)
    {

        $zip = new ZipArchive();


        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();


        $file->move(public_path()."/zip/", $filename);
        $storageDestinationPath= public_path("zip/".$filename);

        $status = $zip->open(public_path("/zip/".$filename));
        if($status){
            $extraction_path= public_path("zip/");
            $zip->extractTo($extraction_path);
            $zip->close();
        }
        $excel_file = public_path('zip/products/product_sample.xlsx');

        Excel::import(new ProductsImport,$excel_file);

        $this->deleteDirectory(public_path("zip"));

        $message = trans('messages.response.products.imported_successfully');
        $response = generateResponse('', true, $message, [], 'object');
        return $response;
    }
    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}
