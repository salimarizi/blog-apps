<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';

    protected $fillable = ['name'];

    public function users() {
        return $this->hasMany(User::class);
    }

    public static function permissions($role) {
        if ($role === "normal") {
            return ['crud:all_posts', 'crud:users'];
        } elseif ($role === "manager") {
            return ['crud:all_posts'];
        }
        return ['crud:own_posts'];
    }
}
