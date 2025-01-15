<?php
define('WEB_ROOT',"/mnt/d/www/ninekedev/webapp/web/nineke/");
if(extension_loaded('swoole')){
     \Workerman\Worker::$eventLoopClass = 'Workerman\Events\Swoole';
}
function run()
{
    ob_start();
    try {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $filename = basename($parsedUrl);
        if (pathinfo($filename, PATHINFO_EXTENSION) === 'php') {
            include WEB_ROOT. $filename; 
        }
    }catch (Throwable  $e) {
        if( strpos(get_class($e),'ExitException')!==false){
            var_dump(get_class($e));
            $res=ob_get_clean();
            if(!$res){
                $code=$e->getStatus();
                $res=$code?$code:$res;
            }
            return $res;   
        }
    }
    return ob_get_clean();
}
