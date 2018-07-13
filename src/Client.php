<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2018/7/6
 * Time: 15:01
 */

namespace Jie;


use Elasticsearch\ClientBuilder;

class Client
{

    /**
     * 当前的实例
     * @var array
     */
    static $instanceArray = [];

    /**
     * 当前访问的实例key
     * @var string
     */
    protected static $modelCache = "";

    /**
     * @var \Elasticsearch\Client
     */
    protected $connect;

    public function __construct(array $config)
    {
        if (!isset($config['url'])) {
            throw new \Exception("url is invalid");
        }
        $port          = $config['port'] ?? 9200;
        $user          = $config['user'] ?? '';
        $pwd           = $config['pwd'] ?? '';
        $this->connect = self::instanceContent($config['url'], $port, $user, $pwd);
    }

    /**
     * @param $url
     * @param int $port
     * @param string $user
     * @param string $pwd
     * @return \Elasticsearch\Client
     */
    public static function instanceContent($url, $port = 9200, $user = "", $pwd = "")
    {
        static::$modelCache = md5(serialize(func_get_args()));
        if (!array_key_exists(static::$modelCache, static::$instanceArray)) {
            $url = $url . ":" . $port;
            if ($user && $pwd) {
                $user = $user . ":" . $pwd;
                $url  = $user . ":" . $user;
            }
            static::$instanceArray[ static::$modelCache ] = ClientBuilder::create()->setHosts([$url])->build();
        }
        return static::$instanceArray[ static::$modelCache ];
    }

    public function test()
    {
        //查看当前版本
        return $this->connect->info();
    }

}