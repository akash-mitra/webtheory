<?php

namespace App\Traits;

use App\Parameter;
use InvalidArgumentException;

trait Shareable
{
    /**
     * Returns the social share url for the given platform.
     *
     * @param string $platform
     * @return string
     * @throws InvalidArgumentException
     */
    public function getShareUrl(string $platform = 'facebook'): string
    {
        $url = $this->{array_get($this->shareOptions, 'url')}
            ? $this->{array_get($this->shareOptions, 'url')}
            : url()->current();

        switch ($platform) {
            case "facebook":
                $queryString = urldecode(
                    http_build_query([
                        'app_id' => Parameter::getKey('FACEBOOK_CLIENT_ID'),
                        'href' => $url,
                        'display' => 'page',
                        'title' => urlencode($this->{array_get($this->shareOptions, 'columns.title')}),
                    ])
                );
                return 'https://www.facebook.com/dialog/share?' . $queryString;

            case "twitter":
                $queryString = urldecode(
                    http_build_query([
                        'url' => $url,
                        'text' => urlencode(
                            str_limit($this->{array_get($this->shareOptions, 'columns.title')}, 120)
                        ),
                    ])
                );
                return 'https://twitter.com/intent/tweet?' . $queryString;

            case "linkedin":
                $queryString = urldecode(
                    http_build_query([
                        'url' => $url,
                        'title' => urlencode($this->{array_get($this->shareOptions, 'columns.title')}),
                    ])
                );
                return 'https://www.linkedin.com/shareArticle/?mini=true&' . $queryString;

            case "pinterest":
                $queryString = urldecode(
                    http_build_query([
                        'url' => $url,
                        'description' => urlencode(
                            $this->{array_get($this->shareOptions, 'columns.title')}
                        ),
                    ])
                );
                return 'https://pinterest.com/pin/create/button/?media=&' . $queryString;

            case "whatsapp":
                $queryString = urldecode(
                    http_build_query([
                        'text' => urlencode(
                            $this->{array_get($this->shareOptions, 'columns.title')} . ' ' . $url
                        ),
                    ])
                );
                return 'https://wa.me/?' . $queryString;

            case "reddit":
                $queryString = urldecode(
                    http_build_query([
                        'url' => $url,
                        'title' => urlencode($this->{array_get($this->shareOptions, 'columns.title')}),
                    ])
                );
                return 'https://www.reddit.com/submit?' . $queryString;

            case "tumblr":
                $queryString = urldecode(
                    http_build_query([
                        'url' => $url,
                        'title' => urlencode($this->{array_get($this->shareOptions, 'columns.title')}),
                    ])
                );

                return 'https://www.tumblr.com/widgets/share/tool/preview?shareSource=legacy&canonicalUrl=&' . $queryString;

            default:
                throw new InvalidArgumentException("Platform " . $platform . " is not supported.");
        }
    }
}
