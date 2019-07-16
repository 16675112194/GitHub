<?php

namespace App\UserListeners\ProductCategory\UpdateProductCategory;


use App\Models\ProductCategory;
use App\UserEvents\ProductCategory\UpdateProductCategory;
use ZhiEq\Contracts\Listener;
use ZhiEq\Exceptions\CustomException;

class WriteCategory extends Listener
{

    /**
     * @param UpdateProductCategory $event
     * @return boolean|string|array
     */
    public function handle($event)
    {
        $fields = [
            'parent_code', 'name', 'image', 'order', 'remark', 'recommend'
        ];
        $model = $event->categoryModel->fillable($fields)->fill(snake_case_array_keys(collect($event->input)->only(camel_case_array($fields))->toArray()));
        if (!empty($event->input['parentCode'])) {
            $category = ProductCategory::whereCode($event->input['parentCode'])->first();
            if (!empty($category->parent_code)) {
                throw new CustomException('只支持二级分类');
            }
            $model->setAttribute('level', $category->level + 1);
        }
        return $model->save();
    }

    /**
     * @return integer
     */
    public function order()
    {
        return 0;
    }
}
