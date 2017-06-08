<?php

use Carbon\Carbon;
use App\Models\Relation;
use Illuminate\Database\Seeder;

/**
 * Class RelationSeeder
 */
class RelationSeeder extends Seeder
{
    /**
     * @var Relation
     */
    private $relation;

    /**
     * @var array
     */
    private $availableRelations = [
        'Son',
        'Daughter',
        'Brother',
        'Sister',
        'Mother',
        'Father',
        'Cousin',
        'Nephew'
    ];

    /**
     * RelationSeeder constructor.
     *
     * @param Relation $relation
     */
    public function __construct(Relation $relation)
    {
        $this->relation = $relation;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->relation->truncate();

        $this->relation->insert($this->getData());
    }

    /**
     * Get Data.
     *
     * @return array
     */
    private function getData()
    {
        $data   = [];

        foreach ($this->availableRelations as $relation) {
            $data[] = [
                'uuid'          => uuid(),
                'relation'      => $relation,
                'slug'          => snake_case($relation),
                'created_at'    => Carbon::now()
            ];
        }

        return $data;
    }
}
