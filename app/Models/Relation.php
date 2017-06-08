<?php

namespace App\Models;

use Carbon\Carbon;
use App\Contracts\RelationContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Relation
 *
 * @package App\Models
 */
class Relation extends Model implements RelationContract
{
    /**
     * @var array
     */
    protected $fillable = ['uuid', 'relation', 'slug'];

    /**
     * Relation belongs to many person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function persons()
    {
        return $this->belongsToMany(Person::class, 'relation_person')->wherePivot('related_to');
    }

    /**
     * Get relation by uuid.
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
     * Create a relation.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->create([
            'uuid'          => uuid(),
            'relation'      => get_data($data, 'relation'),
            'slug'          => snake_case(get_data($data, 'relation')),
            'created_at'    => Carbon::now()
        ]);
    }
}
