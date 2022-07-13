RBAC user manager
=================
...

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist plusser/yii2-rbac-user-manager "*"
```

or add

```
"plusser/yii2-rbac-user-manager": "*"
```

to the require section of your `composer.json` file.

Simple configuration:

1. Change your authManager class to yii\rbac\DbManager (REQUIRED) in web and console config,
    and user identityClass (OPTIONAL but RECOMMENDED for most functionality, because rbacUserManager\models\User extends common\models\User) in web config only.

```
[
  ...
    'components' => [
      ...
        'user' => [
            'identityClass' => 'rbacUserManager\models\User',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
      ...
    ],
  ...
]
```

2. Add rbacUserManager module to your web and console config.

```
[
  ...
    'bootstrap' => [ ..., 'rbacUserManager', ]
    'modules' => [
      ...
        'rbacUserManager' => [
            'class' => 'rbacUserManager\Module',
        ],
      ...
    ],
  ...
]
```
3. Run commands:

```
php yii migrate --migrationPath=@yii/rbac/migrations

php yii rbac-user-manager/init

yii rbac-user-manager/add-user-role -u your_username -r administrator

```
