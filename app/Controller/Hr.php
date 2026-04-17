<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Department;
use Model\Employee;

class Hr
{
    public function departments(Request $request): string
    {
        if ($request->method === 'POST') {
            Department::create($request->all());
            app()->route->redirect('/hr/departments');
        }
        
        $departments = Department::all();
        return (new View())->render('hr.departments', ['departments' => $departments]);
    }

    public function employees(Request $request): string
    {
        if ($request->method === 'POST') {
            Employee::create($request->all());
            app()->route->redirect('/hr/employees');
        }
        
        $employees = Employee::all();
        $departments = Department::all();
        return (new View())->render('hr.employees', [
            'employees' => $employees,
            'departments' => $departments
        ]);
    }

    public function reports(Request $request): string
    {
        $query = Employee::query();
        $data = $request->all();

        if (isset($data['department_id']) && $data['department_id'] !== '') {
            $query->where('department_id', $data['department_id']);
        }

        if (isset($data['employee_type']) && $data['employee_type'] !== '') {
            $query->where('employee_type', $data['employee_type']);
        }

        $employees = $query->get();
        $departments = Department::all();


        $averageAge = 0;
        if (count($employees) > 0) {
            $totalAge = 0;
            foreach ($employees as $emp) {

                $age = date_diff(date_create($emp->birth_date), date_create('today'))->y;
                $totalAge += $age;
            }

            $averageAge = round($totalAge / count($employees), 1);
        }


        return (new View())->render('hr.reports', [
            'employees' => $employees,
            'departments' => $departments,
            'averageAge' => $averageAge
        ]);
    }
}