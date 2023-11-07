<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        "role",
        "class_id",
        'password',
        'full_name',
        'avatar',
        'date_of_birth',
        'address',
        'phone_number',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const STUDENT = 1;
    const INSTRUCTOR = 2;
    const ADMIN = 3;

    public function Classes() {
        return $this->belongsTo(Classes::class, "class_id");
    }

    public function Attendances() {
        return $this->hasMany(Attendance::class, "student_id");
    }

    public function getRole() {
        switch($this->role) {
            case self::STUDENT: return "<span class='text-secondary'>STUDENT</span>";
            case self::INSTRUCTOR: return "<span class='text-info'>INSTRUCTOR</span>";
//            case self::COMPLETE: return "<span class='text-success'>Completed</span>";
            case self::ADMIN: return "<span class='text-danger'>ADMIN</span>";
            default: return "<span class='text-warning'>Not found 404</span>";
        }
    }
}
