<?php

namespace Acquire\Modules\Customer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Customer extends Model
{
    use HasFactory; // SoftDeletes

    protected $table = 'customer';

    protected $guarded = ['id', 'creation_date'];

    protected $appends = [
        'name',
        'dob_formatted',
        'creation_date_formatted',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getDobFormattedAttribute()
    {
        $value = $this->attributes['dob'];

        if (!$value) return $value;

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getCreationDateFormattedAttribute()
    {
        $value = $this->attributes['creation_date'];

        if (!$value) return $value;

        return Carbon::parse($value)->format('Y-m-d');
    }

    protected function casts(): array
    {
        return [
            'dob' => 'date:Y-m-d',
            'creation_date' => 'timestamp',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return CustomerFactory::new();
    }

    /** @inheritDoc */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->creation_date = Carbon::now();
        });
    }
}
