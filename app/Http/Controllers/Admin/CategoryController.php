<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var Category
     */
    private $category;

    public function __construct()
    {
        $this->categoryService = new CategoryService;
        $this->category = new Category;
    }

    public function index(){
        $data = [];
        $categories = $this->categoryService->getCategories(10,null,true);
        $data['categories'] = $categories['result'];
        return view('admin.category.index',compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCategory(Request $request){
        $request->validate([
            "name" => "required",
            "description" => "required",
        ]);
        $this->categoryService->insertCategory($request->all());
        $request->session()->flash('success','Category created successfully!');
        return redirect()->route('admin.categories.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(){
        $data = [];
        $categories = $this->category->parentIdNull()->get();
        $data['categories'] = $categories;
        return view('admin.category.create',compact('data'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id){
        $data = [];
        $category = $this->category->find($id);
        $data['category'] = $category;
        return view('admin.category.edit',compact('data'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request,$id){
        $request->validate([
            "name" => "required",
            "description" => "required",
        ]);
        $this->categoryService->updateCategory($request->all(),$id);
        $request->session()->flash('success','Category updated successfully!');
        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory($id){
        $this->categoryService->delete($id);
        \request()->session()->flash('success','Category deleted successfully!');
        return back();
    }
}
