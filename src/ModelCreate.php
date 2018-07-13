<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2018/7/6
 * Time: 17:32
 */

namespace Jie;


class ModelCreate extends Client
{

    /**
     * @param $db
     * @param $table
     * @param $params
     *
     * [
     * 'id'          => [
     * 'type' => 'integer',
     * ],
     * 'keywords'    => [
     * 'type'  => 'string',
     * 'store' => 'true',
     * "index" => "not_analyzed"
     * ],
     * 'title'       => [
     * 'type'  => 'string',
     * 'store' => 'true'
     * ],
     * 'age'         => [
     * 'type' => 'integer'//可选值为yes或no，指定该字段的原始值是否被写入索引中，默认为no，即结果中不能返回该字段
     * ]
     * ]
     * @return mixed
     */
    public function create($db, $table, $params, $number_of_shards = 5)
    {
        try {
            $params = [
                'index'  => $db,  //索引名（相当于mysql的数据库）
                'client' => ['ignore' => [400, 404]],
                'body'   => [
                    'settings' => [
                        'number_of_shards'          => $number_of_shards,  #分片数
                    ],
                    'mappings' => [
                        "{$table}" => [ //类型名（相当于mysql的表）
                            '_all'       => [
                                'enabled' => false
                            ],
                            '_routing'   => [
                                'required' => false
                            ],
                            'properties' => $params
                        ]
                    ]
                ]
            ];
            return $this->connect->indices()->create($params);
        } catch (\Exception $e) {
            var_export(json_decode($e->getMessage(), true));
            return false;
        }
    }

    public function updateSetting($db, $settling)
    {
        $params = [
            'index' => $db,
            'body'  => [
                'settings' => $settling
            ]
        ];
        return $this->connect->indices()->putSettings($params);
    }

    public function getSetting($db)
    {
        $params = [
            'index' => $db
        ];
        return $this->connect->indices()->getSettings($params);
    }

    public function updateMappings($db, $table, $params)
    {
        $params = [
            'index' => $db,  //索引名（相当于mysql的数据库）
            'type'  => $table,
            'body'  => [
                "{$table}" => [ //类型名（相当于mysql的表）
                    '_all'       => [
                        'enabled' => false
                    ],
                    '_routing'   => [
                        'required' => false
                    ],
                    'properties' => $params
                ]
            ]
        ];
        return $this->connect->indices()->putMapping($params);
    }

    /**
     * db是否存在
     * @param $db
     * @return bool
     */
    public function exit($db)
    {
        $params = [
            'index' => $db
        ];
        return $this->connect->indices()->exists($params);
    }

    /**
     * 删除数据库
     * @param $db
     * @return array
     */
    public function delete($db)
    {
        $params = [
            'index' => $db
        ];
        return $this->connect->indices()->delete($params);
    }
}