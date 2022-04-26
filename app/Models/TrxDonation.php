<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_trx_donation
 * @property int $id_donation
 * @property int $id_transfer_method
 * @property int $status
 * @property integer $nomimal
 * @property string $created_at
 * @property string $updated_at
 * @property Donation $donation
 * @property TransferMethod $transferMethod
 */
class TrxDonation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'trx_donation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_trx_donation';

    /**
     * @var array
     */
    protected $fillable = ['id_donation', 'id_transfer_method', 'status', 'nomimal', 'created_at', 'updated_at','trx_expired'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donation()
    {
        return $this->belongsTo('App\Donation', 'id_donation', 'id_donation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transferMethod()
    {
        return $this->belongsTo('App\TransferMethod', 'id_transfer_method', 'id_transfer_method');
    }
}
