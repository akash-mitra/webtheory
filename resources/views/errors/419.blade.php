{{--
    This blade file is called by Laravel when error is encountered.
    We will first check if there is a custom page specific to
    this error already present in the "active" directory. If
    yes, we will load the custom page. If not, we will load
    the default Laravel provided error page.
--}}
@includeFirst(['active.419', 'errors.default-419'])