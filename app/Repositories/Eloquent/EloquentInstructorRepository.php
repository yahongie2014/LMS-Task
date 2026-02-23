<?php

namespace App\Repositories\Eloquent;

use App\Models\Instructor;
use App\Repositories\Interfaces\InstructorRepositoryInterface;

class EloquentInstructorRepository implements InstructorRepositoryInterface
{
    public function all()
    {
        return Instructor::all();
    }

    public function find($id)
    {
        return Instructor::findOrFail($id);
    }

    public function create(array $data)
    {
        return Instructor::create($data);
    }

    public function update($id, array $data)
    {
        $instructor = $this->find($id);
        $instructor->update($data);
        return $instructor;
    }

    public function delete($id)
    {
        return Instructor::destroy($id);
    }

    public function findByEmail($email)
    {
        return Instructor::where('email', $email)->first();
    }
}
