<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false; // Отключаем метки времени, если они не нужны
    
    // Поля, которые можно массово заполнять
    protected $fillable = ['name', 'type'];

    // Связь: У одного подразделения может быть много сотрудников
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}