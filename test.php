<pre><?php
// header('Content-Type: application/json; charset=utf-8');

$user = [
    [
        'name' => 'faeze',
        'age' => '25'
    ],
    [
        'name' => 'sepehr',
        'age' => '25'
    ],
    [
        'name' => 'saman',
        'age' => '25'
    ],
];

$str = json_encode($user);

var_dump($str);


?></pre>
