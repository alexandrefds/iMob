<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\AnnouncementTypeEnum;
use App\Enums\AnnouncementStatusEnum;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'active',
        'type',
        'status',
        'created_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'type' => AnnouncementTypeEnum::class,
        'status' => AnnouncementStatusEnum::class,
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'active' => false,
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
