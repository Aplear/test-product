<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;

class FormRequest
{
    protected array $data;

    public function __construct(Request $request)
    {
        $this->data = $request->toArray();
    }

    public function all(): array
    {
        return $this->data;
    }

    public function input(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function only(array $keys): array
    {
        return array_intersect_key($this->data, array_flip($keys));
    }

    public function except(array $keys): array
    {
        return array_diff_key($this->data, array_flip($keys));
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    public function validate(): array
    {
        $validated = [];
        $rules = $this->rules();
        foreach ($rules as $key => $rule) {
            if (!isset($this->data[$key]) || empty($this->data[$key])) {
                throw new \Exception("Поле $key не заповнене або відсутнє.");
            }
            $validated[$key] = $this->data[$key];
        }
        return $validated;
    }
}