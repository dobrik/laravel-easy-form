<?php
/**
 * Формы генерируются и проверяются на основе данных в масивах, можно передать ключ из текущего конфига
 *
 * Поля simple НЕ мультиязычные, translatable мультиязычные.
 *
 *  Типы полей:
 *
 * "Input:text" - то это создаст input с атрибутом type = "text"
 *
 * Допустимые параметры конфига для поля:
 * name - имя инпута, помещяется в аттрибут "name"
 * title - заголовок, он же "label"
 * type - тип поля, класс Input'а с неймспейса \App\Forms\Inputs, допустимые значения:
 *  -   Button
 *  -   Image
 *  -   Input - через ":" передается тип "text|checkbox|file"
 *  -   Select - можно получить значения с БД указав через "::" (pages_templates|id,template) - где (таблица|поле_ключа,поле_значения)
 *  или указать заготовленые значения передаем их в виде массива [0 => 'Нет', 1 => 'Да']
 *  -   Textarea
 *  -   'translatable' => true|false признак мультиязычности
 * tab_id - id таба в который нужно поместить поле, если не передать поле попадет в таб 1
 * callback - функция замыкания, которая будет вызвана перед помещением поля в форму принимает 2 аргумента ($field, $model|null)
 * default - стандартное значение, будет установлено если нет значения в модели или не установлено вручную
 * plugins - массив плагинов, классов неймспейса \App\Forms\Plugins, добавляет контент плагина после поля
 * дополнительно передает в плагин ID и name инпута.
 *
 */
return [
    'blog' => [
        'ajax' => true,
        'model' => null,
        'tabs' =>
            [
                [
                    'title' => 'Main',
                    'id' => 1
                ],
                [
                    'title' => 'Content',
                    'id' => 2
                ],
                [
                    'title' => 'Meta',
                    'id' => 3
                ]
            ],
        'fields' => [
            [
                'name' => 'image',
                'title' => 'Image',
                'type' => 'Image',
            ],
            [
                'name' => 'image_preview',
                'title' => 'Image preview',
                'type' => 'Image',
            ],
            [
                'name' => 'background_color',
                'title' => 'Background color',
                'type' => 'Input',
                'plugins' => ['color_picker']
            ],
            [
                'name' => 'published',
                'title' => 'Published',
                'type' => 'Input:checkbox'
            ],
            [
                'name' => 'title',
                'title' => 'Title',
                'type' => 'Input:text',
                'tab_id' => 1,
                'translatable' => true
            ],
            [
                'name' => 'description',
                'title' => 'Description',
                'type' => 'Textarea',
                'plugins' => ['ckeditor'],
                'tab_id' => 2,
                'translatable' => true
            ],
            [
                'name' => 'meta_title',
                'title' => 'Meta title',
                'type' => 'Input:text',
                'tab_id' => 3,
                'translatable' => true
            ],
            [
                'name' => 'meta_keywords',
                'title' => 'Meta keywords',
                'type' => 'Input:text',
                'tab_id' => 3,
                'translatable' => true
            ],
            [
                'name' => 'meta_description',
                'title' => 'Meta description',
                'type' => 'Input:text',
                'tab_id' => 3,
                'translatable' => true
            ],
        ]
    ],
];