<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_type
 * @property string $project_name
 * @property string $created_at
 * @property string $updated_at
 * @property Project[] $projects
 */
class Type extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type';

    /**
     * @var array
     */
    protected $fillable = ['project_name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Project', 'id_type', 'id_type');
    }
}
