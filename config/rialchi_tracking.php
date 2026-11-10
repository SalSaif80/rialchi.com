<?php

return [
    'RLC-98231-SA' => [
        'demo' => true,
        'status' => 'قيد النقل',
        'method' => 'شحن جوي',
        'weight' => '450 كجم',
        'destination' => 'الرياض، السعودية',
        'events' => [
            ['state' => 'done', 'title' => 'تم استلام الشحنة من المورد', 'location' => 'شنغهاي، الصين', 'time' => '28 أكتوبر · 10:00 ص'],
            ['state' => 'done', 'title' => 'مغادرة مطار الشحن', 'location' => 'على متن الرحلة SV-892', 'time' => '29 أكتوبر · 08:30 م'],
            ['state' => 'active', 'title' => 'في الطريق إلى الوجهة', 'location' => 'الشحنة حاليًا في الجو', 'time' => 'الوصول المتوقع: 2 نوفمبر'],
            ['state' => 'pending', 'title' => 'التخليص الجمركي', 'location' => 'مطار الملك خالد، الرياض'],
            ['state' => 'pending', 'title' => 'التسليم', 'location' => 'إلى عنوان المستلم'],
        ],
    ],
];
