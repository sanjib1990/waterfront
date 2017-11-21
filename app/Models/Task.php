<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @package App
 */
class Task extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
    ];

    /**
     * Get list of tasks for a user.
     *
     * @param array $data
     *
     * @return Collection
     */
    public function list(array $data): Collection
    {
        return $this->where($data)->get();
    }
}
