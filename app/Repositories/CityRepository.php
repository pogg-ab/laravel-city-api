<?php

namespace App\Repositories;

class CityRepository
{
    /**
     * Store cities using Laravel's cache (file driver by default),
     * so state persists across HTTP requests without a database.
     */
    
    /** @var string */
    protected string $citiesKey = 'cities';
    /** @var string */
    protected string $nextIdKey = 'cities_next_id';

    public function __construct()
    {
        // Initialize cache if empty.
        if (!\Illuminate\Support\Facades\Cache::has($this->citiesKey) || !\Illuminate\Support\Facades\Cache::has($this->nextIdKey)) {
            $this->reset();
        }
    }

    /**
     * Return all stored cities.
     */
    public function all(): array
    {
        $cities = \Illuminate\Support\Facades\Cache::get($this->citiesKey, []);
        return array_values($cities);
    }

    /**
     * Find a city by id.
     */
    public function find(int $id): ?array
    {
        $cities = \Illuminate\Support\Facades\Cache::get($this->citiesKey, []);
        return $cities[$id] ?? null;
    }

    /**
     * Create a new city.
     */
    public function create(array $data): array
    {
        $nextId = (int) \Illuminate\Support\Facades\Cache::get($this->nextIdKey, 1);
        $city = [
            'id' => $nextId,
            'name' => $data['name'],
            'country' => $data['country'],
            'population' => array_key_exists('population', $data) && $data['population'] !== null
                ? (int) $data['population']
                : null,
        ];

        $cities = \Illuminate\Support\Facades\Cache::get($this->citiesKey, []);
        $cities[$city['id']] = $city;
        \Illuminate\Support\Facades\Cache::forever($this->citiesKey, $cities);
        \Illuminate\Support\Facades\Cache::forever($this->nextIdKey, $nextId + 1);

        return $city;
    }

    /**
     * Update an existing city.
     */
    public function update(int $id, array $data): ?array
    {
        $cities = \Illuminate\Support\Facades\Cache::get($this->citiesKey, []);
        if (! isset($cities[$id])) {
            return null;
        }

        $cities[$id] = [
            'id' => $id,
            'name' => $data['name'],
            'country' => $data['country'],
            'population' => array_key_exists('population', $data) && $data['population'] !== null
                ? (int) $data['population']
                : null,
        ];

        \Illuminate\Support\Facades\Cache::forever($this->citiesKey, $cities);
        return $cities[$id];
    }

    /**
     * Delete a city by id.
     */
    public function delete(int $id): bool
    {
        $cities = \Illuminate\Support\Facades\Cache::get($this->citiesKey, []);
        if (! isset($cities[$id])) {
            return false;
        }

        unset($cities[$id]);
        \Illuminate\Support\Facades\Cache::forever($this->citiesKey, $cities);

        return true;
    }

    /**
     * Reset storage to a predictable seed.
     */
    public function reset(?array $seed = null): void
    {
        \Illuminate\Support\Facades\Cache::forever($this->citiesKey, []);
        \Illuminate\Support\Facades\Cache::forever($this->nextIdKey, 1);

        $seed ??= [
            ['name' => 'Addis Ababa', 'country' => 'Ethiopia', 'population' => 5060000],
            ['name' => 'Nairobi', 'country' => 'Kenya', 'population' => 4397000],
            ['name' => 'Kigali', 'country' => 'Rwanda', 'population' => 1250000],
        ];

        foreach ($seed as $city) {
            $this->create($city);
        }
    }
}
