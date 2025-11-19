<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = 
    ['name', 'author_id', 'publisher_id'];

    protected function name(): Attribute {
        return Attribute::make(
            get: fn (string $value) => mb_convert_case($value, MB_CASE_TITLE, "UTF-8"),
            set: fn (string $value) => mb_convert_case($value, MB_CASE_UPPER, "UTF-8"),
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function bookDetail(): HasOne
    {
        return $this->hasOne(BookDetail::class, 'book_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
