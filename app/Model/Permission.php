<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //1.关联的数据表
    public $table='permission';

    //2.表的主键
    public $primaryKey='id';

    //3.允许操作的字段
//    public $fillable=['user_name','user_pass','email','phone',];

    //不允许
    public $guarded=[];

    //4是否维护created_at和 updated_at字段
    public $timestamps = false;

    //添加动态属性
    public function permission(){

        return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
    }
}
