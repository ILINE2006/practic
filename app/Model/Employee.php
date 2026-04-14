<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'last_name', 'first_name', 'middle_name',
        'gender', 'birth_date', 'address',
        'position', 'composition', 'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Расчёт возраста средствами чистого PHP (Carbon не используется)
    public function getAgeAttribute()
    {
        $birthDate = new \DateTime($this->birth_date);
        $today = new \DateTime('today');
        return $birthDate->diff($today)->y;
    }
}