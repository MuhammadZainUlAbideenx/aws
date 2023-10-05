<?php

namespace App\Imports\CMS;

use App\Models\CMSModels\Media;
use App\Models\CMSModels\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Str;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;


class ProductsImport implements ToCollection, WithValidation, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $default_language = defaultLanguage();
        foreach ($rows as $row) {
            $product =  Product::create([
                'vendor_id' => $row['vendor_id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'short_description' => $row['short_description'],
                'refund_policy' => $row['refund_policy'],
                'product_type' => $row['product_type'],
                'modal' => $row['modal'],
                'is_feature' => $row['is_feature'],
                'price' => $row['price'],
                'sku' => $row['sku'],
                'quantity' => $row['quantity'],
                'available_date' => $row['available_date'],
                'weight' => $row['weight'],
                'unit_id' => $row['unit_id'],
                'is_active' => $row['is_active'],
                'manufacturer_id' => $row['manufacturer_id'],
                'brand_id' => $row['brand_id'],
                'tax_class_id' => $row['tax_class_id'],
                'product_ordered' => $row['product_ordered'],
                'product_liked' => $row['product_liked'],
                'slug' => $row['slug'],
                'external_link' => $row['external_link'],
                'max_order' => $row['max_order'],
                'min_order' => $row['min_order'],
                'shipping_weight' => $row['shipping_weight']
            ]);
            DB::table('product_category')->insert([
                'product_id' => $product->id,
                'category_id' => $row['category_id']
            ]);
            $product_images = public_path('zip/products/product_images/' . $row['image']);

            if (file_exists($product_images)) {
                if (!file_exists(public_path('media/image'))) {
                    mkdir(public_path('media/image'), 0755, true);
                }
                if (!file_exists(public_path('media/image/thumbnails'))) {
                    mkdir(public_path('media/image/thumbnails'), 0755, true);
                }
                if (!file_exists(public_path('media/video'))) {
                    mkdir(public_path('media/video'), 0755, true);
                }
                if (!file_exists(public_path('media/video/thumbnails'))) {
                    mkdir(public_path('media/video/thumbnails'), 0755, true);
                }
            $product_images = new UploadedFile($product_images,$row['image']);

                $file =  $product_images;
                $type = $file->getMimeType();
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = time() . '_' . $file->getClientOriginalName();
                // save genuine image
                if (strstr($type, 'image/')) {
                    $type = 'image';
                    $file_resize = Image::make($file->getRealPath());
                    $file_resize->save(public_path('media/' . $type . '/' . $filename));
                    $image = $file_resize;
                }
                $height = $image->height();
                $width = $image->width();
                $file_url = '/api/media/' . $type . '/' . $filename;
                $user = auth()->user();
                $user_type = $user->role->name;
                $user_id = $user->id;
                $media = Media::create([
                    'name' => $name,
                    'mime_type' => $file->getClientOriginalExtension(),
                    'original_media_path' => $file_url,
                    'type' => $type,
                    'width' => $width,
                    'height' => $height,
                    'user_type' => $user_type,
                    'user_id' => $user_id
                ]);
                // generate thumbnails
                $media->generateThumbnails($image);

                $additional_columns = [];
                $additional_columns['sort_order'] = 0;
                $additional_columns['description'] = $name;
                $additional_columns['alt_text'] = $name;
                $product->media()->attach($media->id, $additional_columns);
            }
        }
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'refund_policy' => 'required|string',
            'weight' => 'required|numeric',
            'sku' => 'required_if:product_type,1',
            'unit_id' => 'required|numeric|exists:units,id',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            //   'category_id' => 'required',
            'modal' => 'required|string',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'brand_id' => 'exists:brands,id|nullable',
            'tax_class_id' => 'required|exists:tax_classes,id',
            'max_order' => 'required|numeric',
            'min_order' => 'required|numeric',
            'is_active' => 'required|boolean',
            'product_type' => 'required',
            'available_date' => 'required',
            'shipping_weight' => 'required|integer',

        ];
    }
}
