<?php
/**
 * This file is part of Adapterman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    Joan Miquel<https://github.com/joanhey>
 * @copyright Joan Miquel<https://github.com/joanhey>
 * @link      https://github.com/joanhey/AdapterMan
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

 use Adapterman\Http;

/**
 * Session functions
 */

 /**
 * Create new session id
 *
 * @link https://www.php.net/manual/en/function.session-create-id.php
 */
uopz_set_return("session_create_id", function(string $prefix = "") { 
    return Http::sessionCreateId(); 
}, true );

/**
 * Get and/or set the current session id
 * 
 * @link https://www.php.net/manual/en/function.session-id.php
 */
uopz_set_return("session_id", function(?string $id = null) { 
    return Http::sessionId($id); 
}, true );
/**
 * Get and/or set the current session name
 *
 * @link https://www.php.net/manual/en/function.session-name.php
 */
uopz_set_return("session_name", function(?string $name = null) { 
    return Http::sessionName($name); 
}, true );
/**
 * Get and/or set the current session save path
 *
 * @link https://www.php.net/manual/en/function.session-save-path.php
 */
uopz_set_return("session_save_path", function(?string $path = null) { 
    return Http::sessionSavePath($path);
}, true );
/**
 * Returns the current session status
 *
 * @link https://www.php.net/manual/en/function.session-status.php
 */
uopz_set_return("session_status", function() { 
    return Http::sessionStatus();
}, true );
/**
 * Start new or resume existing session
 *
 * @link https://www.php.net/manual/en/function.session-start.php
 */
uopz_set_return("session_start", function(array $options = []) { 
    return Http::sessionStart();
}, true );
/**
 * Write session data and end session
 * 
 * @link https://www.php.net/manual/en/function.session-write-close.php
 */

uopz_set_return("session_write_close", function() { 
    return Http::sessionWriteClose();
}, true );
/**
 * Update the current session id with a newly generated one
 *
 * @link https://www.php.net/manual/en/function.session-regenerate-id.php
 */
uopz_set_return("session_regenerate_id", function(bool $delete_old_session = false) { 
    return Http::sessionRegenerateId($delete_old_session);
}, true );
/**
 * Free all session variables
 *
 * @link https://www.php.net/manual/en/function.session-unset.php
 */
uopz_set_return("session_unset", function() { 
    if(session_status() === PHP_SESSION_ACTIVE) {
        $_SESSION = [];
        
        return true;
    }

    return false;
}, true );
/**
 * Get the session cookie parameters
 *
 * @link https://www.php.net/manual/en/function.session-get-cookie-params.php
 */
uopz_set_return("session_get_cookie_params", function() { 
    return Http::sessionGetCookieParams();
}, true );
/**
 * Set the session cookie parameters
 *
 * @link https://www.php.net/manual/en/function.session-set-cookie-params.php
 */

uopz_set_return("session_set_cookie_params", function( $lifetime_or_options,
?string $path = null,
?string $domain = null,
?bool $secure = null,
?bool $httponly = null
) { 
    return Http::sessionSetCookieParams($lifetime_or_options, $path, $domain, $secure, $httponly);
}, true );