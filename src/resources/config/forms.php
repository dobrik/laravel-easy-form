<?php

return [
    'page' => [
        'child' => [
            [
                'type' => 'Input:text',
                'title' => 'Title',
                'name' => 'title',
            ],
            [
                'type' => 'Input:text',
                'title' => 'Slug',
                'name' => 'slug',
            ],
            [
                'type' => 'Input:checkbox',
                'name' => 'published',
                'title' => 'Published',
            ],
            [
                'name' => 'description',
                'title' => 'Description',
                'type' => 'Textarea',
            ],
            [
                'title' => 'Save',
                'type' => 'Button',
                'class' => 'btn btn-success'
            ]
        ]
    ]
];
