<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //1.关联的数据表
    public $table='article';

    //2.表的主键
    public $primaryKey='art_id';

    //3.允许操作的字段
//    public $fillable=['user_name','user_pass','email','phone',];

    //不允许
    public $guarded=[];

    //4是否维护created_at和 updated_at字段
    public $timestamps = false;
}
