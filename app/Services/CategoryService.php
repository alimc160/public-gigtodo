<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoryService constructor.
     */
    public function __construct()
    {
        $this->category = new Category;
    }

    /**
     * @param $perPage
     * @param $request
     * @param false $paginate
     * @return array
     */
    public function getCategories($perPage, $request, $paginate = false){
        $category = $this->category;
        $total = 0;
        if ($paginate == false) {
            $categories = $category->orderBy('id', 'desc')->get();
            $total = $category->count();
        } else {
            $categories = $category->orderBy('id', 'desc');
            $total = $category->get()->count();
            $categories = $category->paginate($perPage);
        }
        return ['result' => $categories, 'total' => $total];
    }

    /**
     * @param $request
     * @return array
     */
    public function insertCategory($request)
    {
        $filePath = null;
        if (isset($request['image'])) {
            $file = $request['image'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/categories';
            $file->move($destinationPath, $fileName);
            $filePath ='uploads/categories/' . $fileName;
        }
        if ($filePath != null) {
            $request = array_merge($request, ['image' => $filePath]);
        }
        $category = $this->category->create($request);
        return ['status' => 'success', 'result' => $category];
    }

    /**
     * @param $request
     * @param $id
     * @return array
     */
    public function updateCategory($request, $id)
    {
        $category=$this->category->find($id);
        $filePath = null;
        if (isset($request['image'])) {
            if ($category->image!="" && $category->image!=null){
                if (file_exists(public_path().'/'.$category->image)){
                    unlink(public_path().'/'.$category->image);
                }
            }
            $file = $request['image'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/categories';
            $file->move($destinationPath, $fileName);
            $filePath = 'uploads/categories/' . $fileName;
        }
        if ($filePath != null) {
            $request = array_merge($request, ['image' => $filePath]);
        }
        $category = $category->update($request);
        return ['status' => 'success', 'result' => $category];
    }

    public function delete($id){
        $category=$this->category->find($id);
        if ($category->image!="" && $category->image!=null){
            if (file_exists(public_path().'/'.$category->image)){
                unlink(public_path().'/'.$category->image);
            }
        }
        $category=$category->delete();
        return ['status' => 'success', 'result' => $category];
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getCategoriesListing($request){
        if (isset($request['category_id'])){
           return $this->category->childCategories($request['category_id'])->get();
        }
        return $this->category->parentIdNull()->get();
    }
}
