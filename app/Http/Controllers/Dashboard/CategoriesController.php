<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $request = request();
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            // ->withTrashed()
            ->paginate(); 


        // $query = Category::query();
        // if($name =  $request->query('name'))
        // {
        //     $query->where('name', 'LIKE', "%{$name}%") ;
        // }
        // if($status =  $request->query('status'))
        // {
        //     $query->where('status', '=', $status) ;
        // }

        // $categories = $query->paginate(1);  //return collection object
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $parents = Category::all(); 
        $category = new Category(); 
        return view('dashboard.categories.create', compact('category','parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        //validation as function from Category model
        $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'unique' => 'This is name already exists!'
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        // if($request->hasFile('image'))
        // {
        //     $file = $request->file('image');
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);

        //     $data['image'] = $path;
            
        // }
      
        $category = Category::create($data);

        return Redirect::route('categories.index')->with('success', 'Category is created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try {
            $category = Category::findOrFail($id);

        } catch(Exception $e) {
            return Redirect::route('categories.index')->with('info', 'Category not found!');

        }
       // select * from categories where id <> $id
       // AND (parent_id IS NULL OR parent_id <> $id)
        $parents  = Category::where('id','<>',$id)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                        ->orwhere('parent_id','<>',$id);
             })
                            
            ->get(); 

        return view('dashboard.categories.edit', compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //validation as function from Category model
        $request->validate(Category::rules($id));

        $category  = Category::findOrFail($id);
        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if($new_image)
        {
            $data['image'] = $new_image;
        }
         

        // if($request->hasFile('image'))
        // {
        //     $file = $request->file('image');
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);

        //     $data['image'] = $path;
            
        // }

        $category->update($data);

        if($old_image && $new_image) //if old and new img are exist => delete old img
        {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route('categories.index')->with('success', 'Category Is Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
         $category->delete();

        return Redirect::route('categories.index')->with('success', 'Category Is Deleted');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')->with('success', 'Category Is Restored');;
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if($category->image)
         {
             Storage::disk('public')->delete($category->image);
         }

        return redirect()->route('categories.trash')->with('success', 'Category Is Deleted Forever');;
    }

    protected function uploadImage(Request $request)
    {
        if(!$request->hasFile('image'))
        {
           return; 
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);

        return $path;
    }
}
