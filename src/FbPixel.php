<?php

namespace Nails\Analytics\Driver;

use Nails\Analytics\Driver\FbPixel\Settings;
use Nails\Analytics\Interfaces;
use Nails\Common\Driver\Base;
use Nails\Common\Service\Asset;
use Nails\Environment;
use Nails\Factory;

class FbPixel extends Base implements Interfaces\Driver
{
    /**
     * @return \Nails\Analytics\Interfaces\Driver
     * @throws \Nails\Common\Exception\AssetException
     * @throws \Nails\Common\Exception\FactoryException
     */
    public function boot(): Interfaces\Driver
    {
        $aEnvironment = $this->getSetting(Settings\FbPixel::KEY_ENVIRONMENTS);
        if (!in_array(Environment::get(), $aEnvironment)) {
            return $this;
        }

        /** @var Asset $oAsset */
        $oAsset = Factory::service('Asset');

        $sProfileId = trim($this->getSetting(Settings\FbPixel::KEY_PROFILE_ID));

        if (!empty($sProfileId)) {
            $oAsset
                ->inline(
                    "!function(f,b,e,v,n,t,s)
                    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '" . $sProfileId . "');
                    fbq('track', 'PageView');",
                    $oAsset::TYPE_JS_INLINE_HEADER
                );
        }

        return $this;
    }
}
