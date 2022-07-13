<?php

use yii\rbac\Item as rbacItem;
use rbacUserManager\components\UserProfileOwnerRule;

return [
	'rules' => [
		UserProfileOwnerRule::class,
	],
	'permissions' => [
		[
			'name' => 'permissionCreate',
			'ruleName' => NULL,
			'description' => 'Разрешение создавать новые разрешения.',
		],
		[
			'name' => 'permissionDelete',
			'ruleName' => NULL,
			'description' => 'Разрешение удалять разрешения.',
		],
		[
			'name' => 'permissionIndex',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать список разрешений.',
		],
		[
			'name' => 'permissionUpdate',
			'ruleName' => NULL,
			'description' => 'Разрешение обновлять разрешения.',
		],
		[
			'name' => 'permissionView',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать разрешения.',
		],
		[
			'name' => 'roleCreate',
			'ruleName' => NULL,
			'description' => 'Разрешение создавать новые роли.',
		],
		[
			'name' => 'roleDelete',
			'ruleName' => NULL,
			'description' => 'Разрешение удалять роли.',
		],
		[
			'name' => 'roleIndex',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать список ролей.',
		],
		[
			'name' => 'roleUpdate',
			'ruleName' => NULL,
			'description' => 'Разрешение обновлять роли.',
		],
		[
			'name' => 'roleView',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать роли.',
		],
		[
			'name' => 'ruleIndex',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать список правил.',
		],
		[
			'name' => 'userCreate',
			'ruleName' => NULL,
			'description' => 'Разрешение регистрировать новых пользователей.',
		],
		[
			'name' => 'userDelete',
			'ruleName' => NULL,
			'description' => 'Разрешение удалять пользователей.',
		],
		[
			'name' => 'userIndex',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать список пользователей.',
		],
		[
			'name' => 'userProfileOwner',
			'ruleName' => 'isUserProfileOwner',
			'description' => 'Разрешение просматривать и редактировать свой профиль.',
		],
		[
			'name' => 'userRoleUpdate',
			'ruleName' => NULL,
			'description' => 'Разрешение обновлять роли пользователей.',
		],
		[
			'name' => 'userUpdate',
			'ruleName' => NULL,
			'description' => 'Разрешение обновлять профили пользователей.',
		],
		[
			'name' => 'userView',
			'ruleName' => NULL,
			'description' => 'Разрешение просматривать профили пользователей.',
		],
	],
	'roles' => [
		[
			'name' => 'user',
			'ruleName' => NULL,
			'description' => 'Пользователь.',
			'children' => [
				'userProfileOwner' => rbacItem::TYPE_PERMISSION,
			],
		],
		[
			'name' => 'userManager',
			'ruleName' => NULL,
			'description' => 'Управление пользователями.',
			'children' => [
				'user' => rbacItem::TYPE_ROLE,
				'userCreate' => rbacItem::TYPE_PERMISSION,
				'userDelete' => rbacItem::TYPE_PERMISSION,
				'userIndex' => rbacItem::TYPE_PERMISSION,
				'userRoleUpdate' => rbacItem::TYPE_PERMISSION,
				'userUpdate' => rbacItem::TYPE_PERMISSION,
				'userView' => rbacItem::TYPE_PERMISSION,
			],
		],
		[
			'name' => 'permissionManager',
			'ruleName' => NULL,
			'description' => 'Управление доступами.',
			'children' => [
				'permissionCreate' => rbacItem::TYPE_PERMISSION,
				'permissionDelete' => rbacItem::TYPE_PERMISSION,
				'permissionIndex' => rbacItem::TYPE_PERMISSION,
				'permissionUpdate' => rbacItem::TYPE_PERMISSION,
				'permissionView' => rbacItem::TYPE_PERMISSION,
				'user' => rbacItem::TYPE_ROLE,
			],
		],
		[
			'name' => 'roleManager',
			'ruleName' => NULL,
			'description' => 'Управление ролями.',
			'children' => [
				'roleCreate' => rbacItem::TYPE_PERMISSION,
				'roleDelete' => rbacItem::TYPE_PERMISSION,
				'roleIndex' => rbacItem::TYPE_PERMISSION,
				'roleUpdate' => rbacItem::TYPE_PERMISSION,
				'roleView' => rbacItem::TYPE_PERMISSION,
				'user' => rbacItem::TYPE_ROLE,
			],
		],
		[
			'name' => 'administrator',
			'ruleName' => NULL,
			'description' => 'Администратор.',
			'children' => [
				'permissionCreate' => rbacItem::TYPE_PERMISSION,
				'permissionDelete' => rbacItem::TYPE_PERMISSION,
				'permissionIndex' => rbacItem::TYPE_PERMISSION,
				'permissionUpdate' => rbacItem::TYPE_PERMISSION,
				'permissionView' => rbacItem::TYPE_PERMISSION,
				'roleCreate' => rbacItem::TYPE_PERMISSION,
				'roleDelete' => rbacItem::TYPE_PERMISSION,
				'roleIndex' => rbacItem::TYPE_PERMISSION,
				'roleUpdate' => rbacItem::TYPE_PERMISSION,
				'roleView' => rbacItem::TYPE_PERMISSION,
				'ruleIndex' => rbacItem::TYPE_PERMISSION,
				'user' => rbacItem::TYPE_ROLE,
				'userCreate' => rbacItem::TYPE_PERMISSION,
				'userDelete' => rbacItem::TYPE_PERMISSION,
				'userIndex' => rbacItem::TYPE_PERMISSION,
				'userProfileOwner' => rbacItem::TYPE_PERMISSION,
				'userRoleUpdate' => rbacItem::TYPE_PERMISSION,
				'userUpdate' => rbacItem::TYPE_PERMISSION,
				'userView' => rbacItem::TYPE_PERMISSION,
			],
		],
	],
];
