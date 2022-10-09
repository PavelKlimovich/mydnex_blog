<?php

namespace Src\Session;

class Session
{   

    /**
     * Create Aurth Session.
     *
     * @param string $value
     * @return void
     */
    public static function addAuth(string $value): void
    {
        $_SESSION['auth'] = $value;
        $_SESSION['_MUA'] = $_SERVER['HTTP_USER_AGENT'];
        session_regenerate_id();
    }

    /**
     * Create new session.
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public static function add(string $name, string $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Return session value.
     *
     * @param string $name
     * @return string|null
     */
    public static function get(string $name): ?string
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    /**
     * Create error session.
     *
     * @param string $value
     * @return void
     */
    public static function error(string $value): void
    {
        $_SESSION['error'] = $value;
        $_SESSION['error_delay'] = '1';
    }

    /**
     * Create success session.
     *
     * @param string $value
     * @return void
     */
    public static function success(string $value): void
    {
        $_SESSION['success'] = $value;
        $_SESSION['success_delay'] = '1';
    }

    /**
     * Verify if is the auth session.
     *
     * @return boolean
     */
    public static function user_agent_matches(): bool
    {
        if(!isset($_SESSION['_MUA'])) { return false; }
        if(!isset($_SERVER['HTTP_USER_AGENT'])) { return false; }
        if($_SESSION['_MUA'] === $_SERVER['HTTP_USER_AGENT']) { return true; }

        return false;
    }
}