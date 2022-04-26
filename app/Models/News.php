<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_news
 * @property int $id_project
 * @property string $news_date
 * @property string $title
 * @property string $description
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 * @property Project $project
 */
class News extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_news';

    /**
     * @var array
     */
    protected $fillable = ['id_project', 'news_date', 'title', 'description', 'photo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'id_project', 'id_project');
    }
}
