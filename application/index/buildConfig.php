<?php

return [
    'lotus_admin_user' => [
        /**
         * 禁用的字段
         */
        'Disable' => [
			'id',
            'last_login_time',
            'last_login_ip',
            'create_time',
            'update_time'
        ],
        /**
         * 字段规则
         */
        'rule' => [
            'username' => 'require',
            'password' => 'require',
            'mobile' => 'require',
            'email' => 'require'
        ],
        /**
         *表单类型 
         */
        'form' => [
            'password' => 'password'
        ],
        /**
         * 字段名称
         */
        'title' => [
            'username' => '用户名',
            'password' => '用户密码',
			'status' => '用户状态'
        ]
    
    ]
];