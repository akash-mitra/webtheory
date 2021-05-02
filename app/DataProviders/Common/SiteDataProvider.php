<?php

namespace App\DataProviders\Common;

use App\Parameter;
use Illuminate\Support\Str;

class SiteDataProvider {

    private array $siteInfo;
    private array $shareOptions;

    public function __construct()
    {
        $this->siteInfo = json_decode(Parameter::getKey('siteinfo'), true);

        $this->shareOptions = json_decode(Parameter::getKey('share'), true);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->siteInfo['name'];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->siteInfo['title'];
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->siteInfo['desc'];
    }

    /**
     * @return string
     */
    public function logo(): string
    {
        return $this->siteInfo['logo'];
    }

    /**
     * Returns the location of the favicon of the site.
     *
     * @return string
     */
    public function favicon(): string
    {
        return $this->siteInfo['icon'];
    }



    /**
     * @param string $platform
     * @return bool
     */
    public function canShare(string $platform): bool
    {
        return $this->shareOptions[$this->getShareKeyName($platform)] !== 'Off';
    }

    private function getShareKeyName(string $platform): string
    {
        if (Str::startsWith($platform, "facebook")) return 'facebook_share';
        if (Str::startsWith($platform, "twitter")) return 'twitter_post';
        if (Str::startsWith($platform, "pinterest")) return 'pinterest_pin';
        if (Str::startsWith($platform, "linkedin")) return 'linkedin_post';
        if (Str::startsWith($platform, "whatsapp")) return 'whatsapp_send';
        if (Str::startsWith($platform, "reddit")) return 'reddit_share';
        if (Str::startsWith($platform, "tumbler")) return 'tumblr_share';
        return '';
    }



}

