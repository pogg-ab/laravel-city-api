<?php

namespace App\Repositories;

class CityRepository
{
    /**
     * @var array<int, array<string, int|string>>
     */
    protected array $cities = [];

    protected int $nextId = 1;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Return all stored cities.
     */
    public function all(): array
    {
        return array_values($this->cities);
    }

    /**
     * Find a city by id.
     */
    public function find(int $id): ?array
    {
        return $this->cities[$id] ?? null;
    }

    /**
     * Create a new city.
     */
    public function create(array $data): array
    {
        $city = [
            'id' => $this->nextId++,
            'name' => $data['name'],
            'country' => $data['country'],
            'population' => (int) $data['population'],
        ];

        $this->cities[$city['id']] = $city;

        return $city;
    }

    /**
     * Update an existing city.
     */
    public function update(int $id, array $data): ?array
    {
        if (! isset($this->cities[$id])) {
            return null;
        }

        $this->cities[$id] = [
            'id' => $id,
            'name' => $data['name'],
            'country' => $data['country'],
            'population' => (int) $data['population'],
        ];

        return $this->cities[$id];
    }

    /**
     * Delete a city by id.
     */
    public function delete(int $id): bool
    {
        if (! isset($this->cities[$id])) {
            return false;
        }

        unset($this->cities[$id]);

        return true;
    }

    /**
     * Reset storage to a predictable seed.
     */
    public function reset(?array $seed = null): void
    {
        $this->cities = [];
        $this->nextId = 1;

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
