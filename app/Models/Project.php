<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_project
 * @property int $id_type
 * @property string $project_name
 * @property string $start_date
 * @property string $end_date
 * @property integer $target_fund
 * @property integer $current_fund
 * @property string $created_at
 * @property string $updated_at
 * @property Type $type
 * @property Donation[] $donations
 */
class Project extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'project';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_project';

    /**
     * @var array
     */
    protected $fillable = ['id_type', 'project_name', 'start_date', 'end_date', 'target_fund', 'current_fund', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Type', 'id_type', 'id_type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donations()
    {
        return $this->hasMany('App\Donation', 'id_project', 'id_project');
    }
}
