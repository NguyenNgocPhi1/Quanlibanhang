<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Models\Language;
use App\Traits\QueryScopes;

class ProductCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
        'follow'
    ];

    protected $table = 'product_catalogues';

    public function languages(){
        return $this->belongsToMany(Language::class,'product_catalogue_language','product_catalogue_id','language_id')
        ->withPivot('name','description','content','meta_title','meta_keyword','meta_description','canonical')->withTimestamps();
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_catalogue_product','product_catalogue_id','product_id');
    }

    public function product_catalogue_language(){
        $locale = app()->getLocale();
        $language = Language::where('canonical', $locale)->first();
        return $this->hasMany(ProductCatalogueLanguage::class,'product_catalogue_id','id')->where('language_id','=',$language->id);
    }

    public static function isNodeCheck($id = 0){
        $productCatalogue = ProductCatalogue::find($id);
        if($productCatalogue->rgt - $productCatalogue->lft !== 1){
            return false;
        }

        return true;
    }

    public function getNameByLanguage($id, $language){
        
    }

}
