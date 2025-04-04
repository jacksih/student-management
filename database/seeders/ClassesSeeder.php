<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::factory()
            ->count(10)
            ->sequence(fn($sequence) => ['name' => 'Class ' . $sequence->index+1])
            ->has(
                Section::factory()
                    ->count(5)
                    ->state(
                        new Sequence(
                            ['name' => 'A'],
                            ['name' => 'B'],
                            ['name' => 'C'],
                            ['name' => 'D'],
                            ['name' => 'E']
                            )
                        )

                    ->has(
                        Student::factory()
                            ->count(10)
                            ->state(
                                function (array $attributes, Section $section) {
                                    return ['class_id' => $section->class_id];
                                }
                            )
                    )
                )
                ->create();
    }
}
