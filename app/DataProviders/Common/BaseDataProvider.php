<?php


namespace App\DataProviders\Common;


abstract class BaseDataProvider
{
    public final function site(): SiteDataProvider
    {
        return new SiteDataProvider();
    }

    public final function template(): TemplateDataProvider
    {
        return new TemplateDataProvider();
    }

    public function menu(): MenuDataProvider
    {
        return new MenuDataProvider();
    }

    public function login(): LoginDataProvider
    {
        return new LoginDataProvider();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return auth()->check();
    }

    /**
     * Returns the current user, if authenticated or null otherwise.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function currentUser()
    {
        return auth()->user();
    }

    /**
     * Returns a generic HTML representation of the entire content.
     *
     * @return string
     */
    abstract function html(): string;

    /**
     * Returns the content type, e.g., "page", "category", "form", etc.
     *
     * @return string
     */
    abstract function type(): string;

    /**
     * Returns the title for the webpage.
     *
     * @return string
     */
    abstract function title(): string;

    /**
     * Returns a meta description for the webpage.
     *
     * @return string
     */
    abstract function description(): string;

    /**
     * Returns the canonical url for the webpage.
     *
     * @return string
     */
    abstract function url(): string;

    /**
     * Returns the URL to an image representing the webpage.
     *
     * @return string
     */
    abstract function image(): string;

    /**
     * Returns the meta keywords separated by comma.
     *
     * @return string
     */
    abstract function tags(): string;

}
