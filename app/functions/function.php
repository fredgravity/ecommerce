<?php


use Philo\Blade\Blade;
use voku\helper\Paginator;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Classes\Session;
use \App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

function view($path, $data = []){

    $view = PROOT ."resources" .DS. "views";
    $cache = PROOT . "bootstrap" .DS. "cache";

    $blade = new Blade($view, $cache);

    echo $blade->view()->make($path, $data)->render();
}

function make($fileName, $data){

    extract($data);

    //TURN ON OUTPUT BUFFERING
    ob_start();

    //INCLUDE THE TEMPLATE
    include PROOT."resources". DS . "views". DS. "emails". DS . $fileName .'.php';

    //GET THE BUFFER CONTENT
    $content = ob_get_contents();

    //CLEAN OUTPUT AND TURN OF OUTPUT BUFFERING
    ob_end_clean();

    return $content;


}

function slug($value){
    //REMOVE ALL CHARACTERS NOT IN THIS LIST: UNDERSCORE | LETTERS | NUMBERS | WHITESPACES
    $value = preg_replace('![^'.preg_quote('_').'\pL\PN\s]+!u', '', mb_strtolower($value) );

    //REPLACE UNDERSCORES WITH A DASH
    $value = preg_replace('!['.preg_quote('_').'\s]+!u', '-', $value );

    //REMOVE WHITESPACES
    return trim($value, '-');
}


function paginate($recordsNum, $totalRecords, $tableName, $obj, $role = '', $userID = '', $Qrydata = ''){

    //CREATE A PAGINATION WITH THE NUMBER OF SPECIFIED RECORD AND INSTANTIATE IT (p)
    $pages = new Paginator($recordsNum, 'p');

    //SET THE TOTAL NUMBER OF RECORDS REQUIRED
    $pages->set_total($totalRecords);

    if($role === ''){
        //SELECT THE RECORD TO PAGINATE FROM THE DATABASE

        if ($userID !== ''){
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND user_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());
//            pnd($data);
        }else{
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null ORDER BY created_at DESC ". $pages->get_limit());
        }


    }else if ($role === 'vendor'){

        $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND vendor_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());
    }else{
        //SELECT THE RECORD TO PAGINATE FROM THE DATABASE

        if ($userID !== ''){
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND role = '$role' AND user_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());

        }else{
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND role = '$role' ORDER BY created_at DESC ". $pages->get_limit());
        }


    }

    if ($Qrydata){
        //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD

        $categories = $obj->transform($Qrydata);
    }else{
        //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD
        $categories = $obj->transform($data);
    }


    //GET THE CATEGORIES FROM DB AND CREATE PAGE LINKS
    return [$categories, $pages->page_links()];
}


function paginateWithDetails($recordsNum, $totalRecords, $tableName, $obj, $role = '', $userID = '', $Qrydata = ''){

    //CREATE A PAGINATION WITH THE NUMBER OF SPECIFIED RECORD AND INSTANTIATE IT (p)
    $pages = new Paginator($recordsNum, 'p');

    //SET THE TOTAL NUMBER OF RECORDS REQUIRED
    $pages->set_total($totalRecords);

    if($role === ''){
        //SELECT THE RECORD TO PAGINATE FROM THE DATABASE

        if ($userID !== ''){
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND user_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());
//            pnd($data);
        }else{
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null ORDER BY created_at DESC ". $pages->get_limit());
        }


    }else if ($role === 'vendor'){

        $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND vendor_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());
    }else{
        //SELECT THE RECORD TO PAGINATE FROM THE DATABASE

        if ($userID !== ''){
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND role = '$role' AND user_id = '$userID' ORDER BY created_at DESC ". $pages->get_limit());

        }else{
            $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND role = '$role' ORDER BY created_at DESC ". $pages->get_limit());
        }


    }

    if ($Qrydata){
        //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD

        $categories = $obj->transformWithDetails($Qrydata);
    }else{
        //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD
        $categories = $obj->transform($data);
    }


    //GET THE CATEGORIES FROM DB AND CREATE PAGE LINKS
    return [$categories, $pages->page_links()];
}

function paginateUsers($recordsNum, $totalRecords, $tableName, $obj){

    //CREATE A PAGINATION WITH THE NUMBER OF SPECIFIED RECORD AND INSTANTIATE IT (p)
    $pages = new Paginator($recordsNum, 'p');

    //SET THE TOTAL NUMBER OF RECORDS REQUIRED
    $pages->set_total($totalRecords);

    //SELECT THE RECORD TO PAGINATE FROM THE DATABASE
    $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND role = 'user' ORDER BY created_at DESC ". $pages->get_limit());

    //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD
    $categories = $obj->transform($data);

    //GET THE CATEGORIES FROM DB AND CREATE PAGE LINKS
    return [$categories, $pages->page_links()];
}

function paginateSearch($recordsNum, $totalRecords, $tableName, $search,  $obj){

    //CREATE A PAGINATION WITH THE NUMBER OF SPECIFIED RECORD AND INSTANTIATE IT (p)
    $pages = new Paginator($recordsNum, 'p');

    //SET THE TOTAL NUMBER OF RECORDS REQUIRED
    $pages->set_total($totalRecords);

    //SELECT THE RECORD TO PAGINATE FROM THE DATABASE
    $data = Capsule::select("SELECT * FROM $tableName WHERE deleted_at is null AND name LIKE '%$search%' ORDER BY created_at DESC ". $pages->get_limit());

//    $products = Product::where('name', 'LIKE', "%$request->search%")->get();

    //CALL THE OBJ CLASS AND PERFORM THE TRANSFORM METHOD

    $categories =  transformToArray($obj);

    //GET THE CATEGORIES FROM DB AND CREATE PAGE LINKS
    return [$categories, $pages->page_links()];
}


function transformToArray($data){
    $products = []; //SET UP CATEGORIES ARRAY

    foreach ($data as $field){
        //CARBON FORMAT DATE FROM DB PROPERLY
        $added = new Carbon($field->created_at);

        array_push($products, [
            'id'           => $field->id,
            'name'         => $field->name,
            'price'         => $field->price,
            'description'  => $field->description,
            'quantity'  => $field->quantity,
            'category_id'  => $field->category_id,
            'category_name'  => Category::where('id', $field->category_id)->first()->name,
            'sub_category_id'  => $field->sub_category_id,
            'sub_category_name'  => SubCategory::where('id', $field->sub_category_id)->first()->name,
            'image_path'  => $field->image_path,
            'added' => $added->toFormattedDateString()
        ]);
    }
    return $products;
}


function isAuthenticated(){
    return Session::exist('SESSION_USER_NAME')? true : false;

}


function user(){
    if (isAuthenticated()){
        return User::findOrFail(Session::get('SESSION_USER_ID'));
    }
    return false;
}


function paginateAdvSearch($recordNum, $totalRecords, $request){
    //CREATE A PAGINATION WITH THE NUMBER OF SPECIFIED RECORD AND INSTANTIATE IT (p)
    $pages = new Paginator($recordNum, 'p');

    //SET THE TOTAL NUMBER OF RECORDS REQUIRED
    $pages->set_total($totalRecords);
//    pnd($request);
    $category = $request->category;
    $subCategory = $request->subCategory;
    $max = $request->max;
    $results = [];

    if (empty($category) && empty($subCategory) && empty($max)){
//pnd('hi');


        $results = Product::whereRaw('name LIKE ?', '%'.$request->search.'%')
            ->whereRaw('price >= ?', $request->min)
            ->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

        pnd($results);

    }elseif (empty($category) && empty($subCategory)){
        pnd('hi2');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['price', '>=', $request->min ],
                ['price', '<=', $request->max ],

            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();


    }elseif (empty($category) && empty($max)){
        pnd('hi3');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['sub_category_id', $request->subCategory],
                ['price', '>=', $request->min ],


            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

    }elseif (empty($subCategory)){
        pnd('hi4');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['category_id', $request->category],
                ['price', '>=', $request->min ],
                ['price', '<=', $request->max ],

            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

    }elseif (empty($subCategory) && empty($max)){
        pnd('hi5');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['category_id', $request->category],
                ['price', '>=', $request->min ],
            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

    }elseif (empty($category)){
        pnd('hi6');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['sub_category_id', $request->subCategory],
                ['price', '>=', $request->min ],
                ['price', '<=', $request->max ],
            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

    }elseif ( empty($max)){
//            pnd('hi7');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['category_id', $request->category],
                ['price', '>=', $request->min ],
                ['sub_category_id', $request->subCategory],

            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();

    }else{
        pnd('hi8');
        $results = Product::where(
            [
                ['name', 'LIKE', '%'.$request->search.'%'],
                ['category_id', $request->category],
                ['sub_category_id', $request->subCategory],
                ['price', '>=', $request->min ],
                ['price', '<=', $request->max ],

            ]
        )->with(['category', 'subCategory', 'user'])->orderBy('id', 'desc')->get();
    }



    //GET THE CATEGORIES FROM DB AND CREATE PAGE LINKS
    return [$results, $pages->page_links()];

}









?>