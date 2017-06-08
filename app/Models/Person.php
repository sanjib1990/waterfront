<?php

namespace App\Models;

use Carbon\Carbon;
use App\Contracts\PersonContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @package App\Models
 */
class Person extends Model implements PersonContract
{
    /**
     * @var string
     */
    protected $table    = 'persons';

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'name'];

    /**
     * Person may have many relations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relations()
    {
        return $this->belongsToMany(Relation::class, 'relation_person')->withPivot(['related_to']);
    }

    /**
     * Get Person by uuid.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    /**
     * Create a person.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->create([
            'uuid'          => uuid(),
            'name'          => get_data($data, 'name'),
            'created_at'    => Carbon::now()
        ]);
    }
}
