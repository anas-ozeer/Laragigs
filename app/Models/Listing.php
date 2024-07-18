<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'email',
        'website',
        'logo',
        'tags',
        'description',
        'user_id'
    ];

    public function scopeFilter($query, array $filters) {

        if (!empty($filters['tag']) && empty($filters['search'])) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }

        if (!empty($filters['search']) && empty($filters['tag'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('tags', 'like', $searchTerm)
                  ->orWhere('location', 'like', $searchTerm)
                  ->orWhere('company', 'like', $searchTerm);
            });
        }

        if (!empty($filters['tag']) && !empty($filters['search'])) {
            $tag = '%' . $filters['tag'] . '%';
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where('tags', 'like', $tag)
                  ->where(function($q) use ($searchTerm) {
                      $q->where('title', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('tags', 'like', $searchTerm)
                        ->orWhere('location', 'like', $searchTerm)
                        ->orWhere('company', 'like', $searchTerm);
                  });
        }
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
