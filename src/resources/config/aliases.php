<?php

return [
    'html' => [
        'custom_html' => \Dobrik\LaravelEasyForm\Forms\Html\CustomHtml::class,
        'div' => \Dobrik\LaravelEasyForm\Forms\Html\Div::class,
        'tab' => \Dobrik\LaravelEasyForm\Forms\Html\Tab::class,
        'tabs' => \Dobrik\LaravelEasyForm\Forms\Html\Tabs::class,
        'button' => \Dobrik\LaravelEasyForm\Forms\Html\Button::class,
        'form' => \Dobrik\LaravelEasyForm\Forms\Html\Form::class,
        'image' => \Dobrik\LaravelEasyForm\Forms\Html\Image::class,
        'input' => \Dobrik\LaravelEasyForm\Forms\Html\Input::class,
        'checkbox' => \Dobrik\LaravelEasyForm\Forms\Html\Checkbox::class,
        'select' => \Dobrik\LaravelEasyForm\Forms\Html\Select::class,
        'textarea' => \Dobrik\LaravelEasyForm\Forms\Html\Textarea::class,
        'template' => \Dobrik\LaravelEasyForm\Forms\Html\Template::class,
    ],

    'plugin' => [
        'ckeditor' => \Dobrik\LaravelEasyForm\Forms\Plugin\Ckeditor::class,
        'color_picker' => \Dobrik\LaravelEasyForm\Forms\Plugin\ColorPicker::class,
        'air_date_picker' => \Dobrik\LaravelEasyForm\Forms\Plugin\AirDatePicker::class,
        'datetimepicker' => \Dobrik\LaravelEasyForm\Forms\Plugin\DateTimePicker::class,
        'select2' => \Dobrik\LaravelEasyForm\Forms\Plugin\Select2::class,
        'select2sortable' => \Dobrik\LaravelEasyForm\Forms\Plugin\Select2Sortable::class,
    ],
];
