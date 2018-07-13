<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2018/7/7
 * Time: 19:05
 */

namespace Jie;


class SearchService extends Client
{

    //单个匹配
    public function match($db, $table)
    {
        $post = [
            "index" => $db,
            "type"  => $table,
//            'from'  => 0,
//            'size'  => 20,
            "body"  => [
                'query'   => [
                    'multi_match' => [//从多个字段搜索
                        "query"  => "武杰",
                        "fields" => ['select', "keyword^10"],
                    ]
//                    'match_phrase' => [
//                        'keyword' => "是"
//                    ]
//                    'fuzzy' => [//模糊匹配 ，单词拼错
//                        'select' => [
//                            'value'     => "武杰",
//                            'fuzziness' => "1",
//                        ]
//                    ],
                ],
                "_source" => ["id","select", "keyword"],
                "sort"    => [
                    [
                        'id' => [
                            "order" => "desc"
                        ]
                    ]
                ]
            ]
        ];
        return $this->connect->search($post);
    }

    //多个匹配
    public function matchAll($db, $table)
    {
        $post = [
            "index" => $db,
            "type"  => $table,
            "body"  => [
                'query' => [
                    'bool'     => [
                        "should" => [
                            [
                                'match' => [
                                    'keyword' => [
                                        'query' => "武杰",
                                        'boost' => 3
                                    ]
                                ]
                            ],
                            [
                                'bool' => [
                                    "should" => [
                                        [
                                            'match' => [
                                                'select' => '武杰'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'must'     => [
                        "match" => [
                            "title" => "武杰"
                        ]
                    ],
                    'must_not' => [
                        "match" => [
                            "select" => "武杰"
                        ]
                    ]
                ]
            ]
        ];
        return $this->connect->search($post);
    }
}