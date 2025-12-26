<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;
    
    protected $fillable = ['computer_name', 'model', 'operating_system', 'processor', 'memory', 'available'];

    // Mối quan hệ 1-nhiều: Một máy tính có thể có nhiều vấn đề
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}