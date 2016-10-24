<?

namespace Infuso\Core\Cache;
use Infuso\Core;

class Service extends Core\Service implements Core\Handler {

    /**
     * Объект драйвера кэша
     **/         
    private static $driver = null;
    
    /**
     * Массив для кэша в оперативной памяти
     **/    
    private static $memoryCache = array();
    
    public function defaultService() {
        return "cache";
    }
    
    public static function isSingletonService() {
        return true;
    }
    
    /**
     * Возвращает драйвер кэширущей системы
     * @todo вернуть возможность выбора драйвера
     **/
    private function driver() {

        if(!self::$driver) {
        
            $driver = "filesystem";
            if(function_exists("xcache_unset_by_prefix")) {
                $driver = "xcache";
            }
        
            switch($driver) {
                default:
                case "filesystem":
                    self::$driver = new filesystem();
                    break;
                case "xcache":
                    self::$driver = new xcache();
                    break;
            }
        }
        return self::$driver;
    }

    /**
     * @return mixed Возвращает значение переменной из кэша
     **/
    public static function get($key, $fn = null) {

        \Infuso\Core\Profiler::beginOperation("cache","read",$key);

        if(!array_key_exists($key, self::$memoryCache)) {
            self::$memoryCache[$key] = self::driver()->get($key);
        }
        
        if($fn) {
            if(self::$memoryCache[$key] === null) {
                self::set($key,  $fn());
            }
        }

        \Infuso\Core\Profiler::endOperation();

        return self::$memoryCache[$key];
        
    }

    /**
     * Записывает переменную в кэш
     **/
    public static function set($key, $val, $ttl = null) {
        \Infuso\Core\Profiler::beginOperation("cache","write",$key);
        self::driver()->set($key,$val,$ttl);
        self::$memoryCache[$key] = $val;
        \Infuso\Core\Profiler::endOperation();
    }

    public static function clear() {
        self::driver()->clear();
    }
    
    public static function clearByPrefix($prefix) {
        return self::driver()->clearByPrefix($prefix);
    } 

    /**
     * Обработчик события Хартбит - теста системы
     * @handler = Infuso/heartbeat
     **/
    public function onHeartbeat($event) {
    
        $service = service("cache");
    
        if(get_class($service->driver()) == FileSystem::inspector()->className()) {
            $event->warning("Используется кэш в файловой системе, это медленно.");
        } else {        
            $event->message("Кэш — ок");
        }        
    }
    
}
