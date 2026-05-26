<?php

namespace App\Traits;

trait Searchable
{
    /**
     * Search in multiple columns
     */
    public function scopeSearch($query, $search, $columns = [])
    {
        if (empty($search) || empty($columns)) {
            return $query;
        }

        return $query->where(function ($q) use ($search, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Filter by date range
     */
    public function scopeDateBetween($query, $startDate, $endDate, $column = 'created_at')
    {
        if (!$startDate || !$endDate) {
            return $query;
        }

        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    /**
     * Filter by status
     */
    public function scopeByStatus($query, $status)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Filter by category
     */
    public function scopeByCategory($query, $category)
    {
        if (!$category) {
            return $query;
        }

        return $query->where('kategori', $category);
    }

    /**
     * Filter by user
     */
    public function scopeByUser($query, $userId)
    {
        if (!$userId) {
            return $query;
        }

        return $query->where('user_id', $userId);
    }

    /**
     * Order by latest
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Order by oldest
     */
    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}
