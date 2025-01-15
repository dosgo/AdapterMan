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
 * Send a raw HTTP header
 *
 * @link https://php.net/manual/en/function.header.php
 */
uopz_set_return("header", function(string $content, bool $replace = true, int $http_response_code = 0) { 
    Http::header($content, $replace, $http_response_code);
}, true );
/**
 * Remove previously set headers
 *
 * @param string $name  The header name to be removed. This parameter is case-insensitive.
 * @return void
 *
 * @link https://php.net/manual/en/function.header-remove.php
 */
uopz_set_return("header_remove", function(?string $name = null) { 
    Http::headerRemove($name); 
}, true );
/**
 * Get or Set the HTTP response code
 *
 * @param integer $code [optional] The optional response_code will set the response code.
 * @return integer      The current response code. By default the return value is int(200).
 *
 * @link https://www.php.net/manual/en/function.http-response-code.php
 */
uopz_set_return("http_response_code", function(?int $code = null) { 
    return Http::responseCode($code);
}, true );
/**
 * Returns a list of response headers sent (or ready to send)
 *
 * @return array<string>
 * 
 * @link https://www.php.net/manual/en/function.headers-list.php
 */
uopz_set_return("headers_list", function() { 
    return Http::headers_list();
}, true );

if (! function_exists('getallheaders')) { // It's declared in a dev lib
    /**
     * Fetch all HTTP request headers
     *
     * @return array<string,string>
     * @link https://www.php.net/manual/en/function.getallheaders.php
     */
    function getallheaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
           // if (str_starts_with($key, 'HTTP_')) {
            if(\substr($key, 0, strlen("HTTP_")) === "HTTP_"){
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
            }
        }

        return $headers;
    }
}

/**
 * Send a cookie
 *
 * @param string $name
 * @param string $value
 * @param int|array $expires
 * @param string $path
 * @param string $domain
 * @param boolean $secure
 * @param boolean $httponly
 * @return boolean
 *
 * @link https://php.net/manual/en/function.setcookie.php
 */
uopz_set_return("setcookie", function(string $name, string $value = '',  $expires = 0, string $path = '', string $domain = '', bool $secure = false, bool $httponly = false) { 
    $samesite = '';
    if (is_array($expires)) { // Alternative signature available as of PHP 7.3.0 (not supported with named parameters)
        $expires  = $expires['expires'] ?? 0;
        $path     = $expires['path'] ?? '';
        $domain   = $expires['domain'] ?? '';
        $secure   = $expires['secure'] ?? false;
        $httponly = $expires['httponly'] ?? false;
        $samesite = $expires['samesite'] ?? '';
    }

    return Http::setCookie($name, $value, $expires, $path, $domain, $secure, $httponly, $samesite);
}, true );



/**
 * Limits the maximum execution time
 *
 * @param int $seconds
 * @return bool
 */
uopz_set_return("set_time_limit", function(int $seconds) { 
    return true;
}, true );

/**
 * Checks if or where headers have been sent
 *
 * @link https://www.php.net/manual/en/function.headers-sent.php
 * 
 * @return bool Always false with Adapterman
 */
uopz_set_return("headers_sent", function(?string &$filename = null, ?int &$line = null) { 
    return false;
}, true );

/**
 * Get cpu count
 *
 */
function cpu_count(): int
{
    // Windows does not support the number of processes setting.
    if (\DIRECTORY_SEPARATOR === '\\') {
        return 1;
    }
    $count = 4;
    if (\is_callable('shell_exec')) {
        if (\strtolower(PHP_OS) === 'darwin') {
            $count = (int)\shell_exec('sysctl -n machdep.cpu.core_count');
        } else {
            $count = (int)\shell_exec('nproc');
        }
    }
    return $count > 0 ? $count : 2;
}

/* function exit(string $status = ''): void {  //string|int
    Http::end($status);
} // exit and die are language constructors, change your code with an empty ExitException
 */
