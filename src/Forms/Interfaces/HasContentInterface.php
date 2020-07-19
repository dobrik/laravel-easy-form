<?php

namespace Dobrik\LaravelEasyForm\Forms\Interfaces;

use Dobrik\LaravelEasyForm\Forms\HtmlAbstract;

interface HasContentInterface
{
    public function setContent($content): HtmlAbstract;
}