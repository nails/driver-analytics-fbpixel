<?php

namespace Nails\Analytics\Driver\FbPixel\Settings;

use Nails\Admin\Traits;
use Nails\Common\Helper\Form;
use Nails\Common\Interfaces;
use Nails\Components\Setting;
use Nails\Environment;
use Nails\Factory;

class FbPixel implements Interfaces\Component\Settings
{
    use Traits\Settings\Permission;

    // --------------------------------------------------------------------------

    const KEY_PROFILE_ID   = 'profile_id';
    const KEY_ENVIRONMENTS = 'environments';

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return 'Facebook Pixel';
    }

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function getPermissions(): array
    {
        return [];
    }

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        if (!$this->userHasPermission()) {
            return [];
        }

        /** @var Setting $oProfileId */
        $oProfileId = Factory::factory('ComponentSetting');
        $oProfileId
            ->setKey(static::KEY_PROFILE_ID)
            ->setLabel('Profile ID')
            ->setInfo('If left blank, Facebook Pixel will be disabled.')
            ->setInfoClass('alert alert-warning');

        /** @var Setting $oEnvironments */
        $oEnvironments = Factory::factory('ComponentSetting');
        $oEnvironments
            ->setKey(static::KEY_ENVIRONMENTS . '[]')
            ->setLabel('Enabled On')
            ->setType(Form::FIELD_DROPDOWN_MULTIPLE)
            ->setClass('select2')
            ->setDefault([Environment::ENV_PROD])
            ->setOptions(array_combine(
                Environment::available(),
                Environment::available()
            ));

        return [
            $oProfileId,
            $oEnvironments,
        ];
    }
}
