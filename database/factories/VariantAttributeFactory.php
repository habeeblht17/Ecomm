<?php

namespace Database\Factories;

use App\Models\Variant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantAttribute>
 */
class VariantAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'variant_id' => Variant::pluck('id')->random(),
            'attribute_id' => Attribute::pluck('id')->random(),
            'attribute_value_id' => AttributeValue::pluck('id')->random(),
        ];
    }
}
