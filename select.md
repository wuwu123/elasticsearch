# 查询
[学习地址](https://my.oschina.net/u/2903254/blog/789355)
## 基础查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'match' => [
                        'select' => '哈哈哈'
                    ]
                ]
            ]
        ];
```
### 说明
```text
完全匹配字段 select 是 哈哈 的结果
```

## 多字段查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'multi_match'=>[//从多个字段搜索
                        "query"=>"武杰",
                        "fields"=>['select' , "keyword^10"],
                    ]
                ]
            ]
        ];
```
### 说明
```text
 从 select 和  keyword 里面查询包含 武杰的词语 ，并且 keyword的权重提升，但是 并不是翻十倍
```


## 通配符查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'wildcard'=>[
                        "select"=>"武*",
                    ]
                ]
            ]
        ];
```
### 说明
```text
 查询以 {武} 开头的数据
```


## 正则查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'regexp'=>[
                        "select"=>".*哈",
                    ]
                ]
            ]
        ];
```
### 说明
```text
 查询以 {哈} 结束的数据
```


## Bool 查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'bool' => [
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
```
### 说明
```text
 Bool 可以嵌套的查询语句 ， must 必须包含的字段   must_not 不能包含的字段
```

## 模糊查询
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'fuzzy' => [//模糊匹配 ，单词拼错
                    'select' => [
                        'value'     => "武杰",
                        'fuzziness' => "1",
                    ]
                ],
            ]
        ];
```
### 说明
```text
 拼写错误的编辑距离 默认是 auto 当术语长度大于5时，相当于是2，一般设置为1
```

## 查询排序
```php
<?php
    $data = [
            "index" => 'index',
            "type"  => 'table',
            'from'  => 0,
            'size'  => 20,
            "body"  => [
                'query' => [
                    'regexp'=>[
                        "select"=>".*哈",
                    ]
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
```
### 说明
```text
 查询结果 只要 _source 里面的字段 ， 记过通过id倒序排列
```
