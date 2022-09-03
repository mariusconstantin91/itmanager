<?php

namespace App\Models\Interfaces;

interface ImportanceInterface
{
    const LOWEST = 0;
    const LOW = 1;
    const MEDIUM = 2;
    const HIGH = 3;
    const HIGHEST = 4;

    const PRIORITY_OPTIONS = [
        0 => 'Lowest',
        1 => 'Low',
        2 => 'Medium',
        3 => 'High',
        4 => 'Highest',
    ];
}
