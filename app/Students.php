<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student';

    public $timestamps = false;


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function address()
    {
        return $this->belongsTo(StudentAddress::class, 'id');
    }
}
