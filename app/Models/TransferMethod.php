<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_transfer_method
 * @property string $bank_name
 * @property string $account_no
 * @property string $account_name
 * @property string $created_at
 * @property string $updated_at
 * @property TrxDonation[] $trxDonations
 */
class TransferMethod extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'transfer_method';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_transfer_method';

    /**
     * @var array
     */
    protected $fillable = ['bank_name', 'account_no', 'account_name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxDonations()
    {
        return $this->hasMany('App\TrxDonation', 'id_transfer_method', 'id_transfer_method');
    }
}
