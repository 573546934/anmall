<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseList extends Model
{
    protected $table = 'case_list';
    protected $fillable = ['management_id','description'];

    /*案列多图*/
    public function map()
    {
        return $this->hasMany('App\Models\Attachment', 'for_id', 'id')
            ->where('mark','article');
    }


}
