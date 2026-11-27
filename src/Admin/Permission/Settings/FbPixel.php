<?php

namespace Nails\Analytics\Driver\FbPixel\Admin\Permission\Settings;

use Nails\Admin\Interfaces\Permission;

class FbPixel implements Permission
{
    public function label(): string
    {
        return 'Can manage Facebook Pixel settings';
    }

    public function group(): string
    {
        return 'Settings';
    }
}
