<?php

namespace Sta\CarteMarque;

use Laravel\Nova\Card;

class CarteMarque extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/4';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'CarteMarque';
    }
}
