<?php

require_once __DIR__ . '/types/QueryType.php';
require_once __DIR__ . '/types/MutationType.php';

use GraphQL\Type\Schema;

// Membuat skema GraphQL dengan root query dan mutation
$schema = new Schema([
    'query' => new \App\Types\QueryType(),
    'mutation' => new \App\Types\MutationType()
]);
