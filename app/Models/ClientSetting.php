<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'client_id',
        'user_id',
        'access_token',
        'open_ai_key',
        'phone_number_id',
        'business_account_id',
        'is_connected',
        'app_id',
        'bot_id',
        'webhook_verified',
        'name',
        'username',
        'can_join_groups',
        'can_read_all_group_messages',
        'supports_inline_queries',
        'token_verified',
        'status',
    ];

    protected $casts    = [
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function staff()
    {
        return $this->hasMany(ClientStaff::class, 'client_id', 'id');
    }
}
