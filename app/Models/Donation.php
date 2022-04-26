<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_donation
 * @property int $id_project
 * @property int $id_user
 * @property integer $nomimal
 * @property string $name
 * @property string $nowhatsapp
 * @property string $description
 * @property string $photo
 * @property boolean $is_anonim
 * @property string $created_at
 * @property string $updated_at
 * @property Project $project
 * @property TrxDonation[] $trxDonations
 */
class Donation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'donation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_donation';

    /**
     * @var array
     */
    protected $fillable = ['id_project', 'id_user', 'nomimal', 'name', 'nowhatsapp', 'description', 'photo', 'is_anonim', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'id_project', 'id_project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxDonations()
    {
        return $this->hasMany('App\TrxDonation', 'id_donation', 'id_donation');
    }
}
