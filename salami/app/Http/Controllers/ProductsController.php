<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\Products;
use App\Models\Material;
use App\Http\Resources\Products as ProductsResources;
use App\Http\Resources\Material as MaterialResources;
use Illuminate\Support\Facades\DB;

class ProductsController extends BaseController
{
    public function index() {
        $products = Products::all();
        return $this -> sendResponse(ProductsResources::collection($products),"Husik osszes");
    }
    public function store(Request $request){
        //dd($request);
        $input = $request->all();
        $validator = Validator::make($input,[
            "name" => "required",
            "price" => "required",
            "material_id" => "required"
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $products = Products::create($input);

        return $this->sendResponse(new ProductsResources($products),"Husi kiírva");
    }
    public function show($id){
        $products = Products::find($id);
        if(is_null($products)){
            return $this->sendError("Nincs ilyen husi");
        }
        return $this->sendResponse(new ProductsResources($products),"Husi betöltve");
    }
    public function update(Request $request, Products $products){
        $input = $request -> all();
        $validator = validator::make($input,[
            "name" => "required",
            "price" => "required",
            "material_id" => "required"
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        
        $products -> name = $input["name"];
        $products -> price = $input["price"];
        $products -> material_id = $input["material_id"];
        $products -> save();

        return $this->sendResponse(new ProductsResources($products),"Husi módosítva");
    }
    public function destroy($id){
        Products::destroy($id);
        return $this->sendResponse([],"Husi törölve");
    }
    public function search($name){
        $result = Products::where('name', 'LIKE', '%'. $name. '%')->get();
        if(count($result)){
            return Response()->json($result);
        }
        else
        {
            return response()->json(['Result' => 'Nincs talalat'], 404);
        }
    }
    public function materialsearch($material){
        $result = Material::where('material', 'LIKE', '%'. $material. '%')->join('products', 'materials.id', '=', 'products.material_id')->get();
        if(count($result)){
            return Response()->json($result);
        }
        else
        {
            return response()->json(['Result' => 'Nincs talalat'], 404);
        }
    }
}
