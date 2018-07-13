<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2018/7/7
 * Time: 11:01
 */

namespace Jie;


class ContentService extends ModelCreate
{

    public function addData($db, $table, $data, $id = "")
    {
        $params = [
            'index' => $db,
            'type'  => $table,
            'body'  => $data
        ];
        if (isset($data['id']) && !$id) {
            $id = $data['id'];
        }
        if ($id) {
            $params['id'] = $id;
        }
        return $this->connect->index($params);
    }

    public function get($db, $table, $id)
    {
        $params = [
            'index'          => $db,
            'type'           => $table,
            'id'             => $id,
            'ignore_missing' => 404,
            'client'         => ['verbose' => true]
        ];
        return $this->connect->get($params);
    }

    public function update($db, $table, $id)
    {
        $params = [
            'index' => $db,
            'type'  => $table,
            'id'    => $id,
            "body"  => [
                'doc' => [
                    'select' => '哈哈哈'
                ]
            ]
        ];
        return $this->connect->update($params);
    }

    public function deleteRow($db, $table, $id)
    {
        $params = [
            'index' => $db,
            'type'  => $table,
            'id'    => $id
        ];
        return $this->connect->delete($params);
    }
}