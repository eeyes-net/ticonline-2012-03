# e瞳订票（e瞳大屏幕）

<http://piao.eeyes.net/>（已下线）

* 项目名称：e瞳大屏幕
* 项目代号：ticonline

本仓库仅为旧版e瞳大屏幕

## 时间轴

* 2012年03月14日首次上线测试
* 2012年10月左右才开始正式运营
* 2015年04月14日开始编写新版大屏幕（主要修改主页外观）
* 2015年08月27日新版大屏幕编写完成
* 2015年11月28日中的最后一个活动
* 2017年03月02日项目正式下线
* 2017年03月23日开始整理代码
* 2017年05月27日代码整理结束

## 环境要求

* `php >= 5.3 && php <= 5.6`
* `ext-soap *`开启
* `ext-mysqli *`开启
* `ext-curl *`开启

## 部署

1. 手动新建数据库
    ```mysql
    CREATE DATABASE `ticonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
    USE `ticonline`;
    ```
2. 手动新建表，输入如下SQL语句
    ```mysql
    CREATE TABLE `acinfo` (
      `acid` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
      `actitle` varchar(200) NOT NULL COMMENT '活动标题',
      `acstart` int(20) NOT NULL COMMENT '开始时间',
      `acauthor` varchar(100) NOT NULL COMMENT '发布者',
      `cid` int(11) NOT NULL COMMENT '社团账号信息',
      `acsource` varchar(100) NOT NULL COMMENT '主办方',
      `actext` text NOT NULL COMMENT '活动简介',
      `acend` int(20) NOT NULL COMMENT '截止时间',
      `aclimit` int(10) NOT NULL COMMENT '总共票数',
      `actime` int(20) NOT NULL COMMENT '活动时间',
      `acnow` int(20) NOT NULL DEFAULT '0' COMMENT '当前订票数量',
      `achave` int(11) DEFAULT '0',
      `acstate` int(11) NOT NULL DEFAULT '1' COMMENT '票订完后为0',
      `ac` int(10) unsigned NOT NULL COMMENT '添加管理员id',
      `typeid` int(10) NOT NULL COMMENT '活动分类',
      `acallow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为已审核',
      `actic` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否检票刷卡',
      `acwhere` varchar(20) NOT NULL COMMENT '活动地点',
      `qrkey` varchar(10) NOT NULL,
      `want` int(11) NOT NULL DEFAULT '0' COMMENT '记录想要订票的人数',
      `ptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
      `upload` varchar(255) NOT NULL,
      PRIMARY KEY (`acid`),
      KEY `achave` (`achave`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    CREATE TABLE `actype` (
      `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类id',
      `tname` varchar(8) NOT NULL COMMENT '分类名称',
      `tparid` int(11) NOT NULL DEFAULT '0' COMMENT '恒为0',
      PRIMARY KEY (`tid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    CREATE TABLE `admin` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(200) NOT NULL COMMENT '用户名',
      `pwd` varchar(200) NOT NULL COMMENT 'md5密码',
      `mode` smallint(6) NOT NULL DEFAULT '0' COMMENT '0活动发布，1活动审核，2超级管理员',
      `phone` varchar(13) DEFAULT NULL COMMENT '电话号码',
      `checkinfo` varchar(100) NOT NULL COMMENT '注册时验证信息',
      `checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0用户未审核，1用户已审核',
      `club` varchar(15) CHARACTER SET ucs2 NOT NULL COMMENT '所属社团',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    CREATE TABLE `ticinfo` (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订票记录id',
      `acid` int(11) NOT NULL COMMENT '活动id',
      `uid` int(11) NOT NULL COMMENT '用户id',
      `present` tinyint(1) NOT NULL DEFAULT '0' COMMENT '恒为0',
      `unum` varchar(20) NOT NULL COMMENT '学生学号',
      `verifynum` varchar(12) NOT NULL DEFAULT '0' COMMENT '验证码(新增)',
      `actitle` varchar(200) NOT NULL COMMENT '活动标题',
      `actime` varchar(30) NOT NULL COMMENT '活动时间',
      `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    CREATE TABLE `uinfo` (
      `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
      `uname` varchar(100) NOT NULL COMMENT '用户名',
      `unum` varchar(20) NOT NULL COMMENT '学号',
      `ustate` int(11) NOT NULL DEFAULT '0' COMMENT '恒为0',
      `uphone` varchar(13) DEFAULT ' ' COMMENT '手机号',
      `ucollege` varchar(15) NOT NULL COMMENT '学院',
      PRIMARY KEY (`uid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ```
3. 将代码解压
4. 修改`Conf/config.php`中的配置
5. 手动添加活动类型
    ```mysql
    INSERT INTO `actype` (`tname`) VALUES
    ('文艺晚会'),
    ('学习培训'),
    ('专题讲座'),
    ('实践锻炼'),
    ('主题活动'),
    ('会议讲座');
    ```
6. 访问`/Admin/registe`注册后台管理账号
7. 进入MySQL手动修改为超级管理员权限，这个就是第一个超级管理员，之后的管理员可以通过页面修改
    ```mysql
    UPDATE `admin` SET `mode` = 2 WHERE `name` = 'your_name';
    ```
8. 修改`index.php`中的`APP_DEBUG`改为`false`

## 说明

* 本项目中使用的某些配置由于保密原因，不便于公开
* 本项目接入了学校的CAS，没有自身的登录
* 后台管理的一些账户数据登录时存储到Session中了，所以例如权限升、验证等操作，必须重新登录才能生效

## 文件结构说明

| 路径 | 说明 |
| :--- | :--- |
| / | 项目根目录 |
| /Cas/ | CAS模块（Jasig/phpCAS库） |
| /Cas/CAS/ | Jasig/phpCAS库 |
| /Cas/CAS.php | Jasig/phpCAS库自动加载文件 |
| /Cas/config.php | 西安交通大学的CAS配置 |
| /Cas/README.md | CAS登录模块说明文档，原工程中不包括 |
| /Common/ | 框架的公共文件目录 |
| /Common/extend.php | ThinkPHP3.1官方的扩展助手函数，在项目中没任何作用 |
| /Conf/ | 框架的配置文件目录 |
| /Conf/config.php | 配置文件，可以根据需要手动修改 |
| /images/ | 主页中使用的图片目录 |
| /Lib/ | 代码逻辑目录 |
| /Lib/Action/ | 控制器目录 |
| /Lib/Model/ | 数据库模型目录 |
| /Lib/Taglib/ | 标签库目录 |
| /Lib/Taglib/TagLibHtml.class.php | ThinkPHP3.1官方的扩展标签库 |
| /Public/ | 主页中使用的静态文件目录 |
| /Runtime/ | 运行时文件，需要读写权限 |
| /ThinkPHP/ | ThinkPHP3.1框架 |
| /Tpl/ | 视图模板目录 |
| /uploadfile/ | 上传文件目录 |
| /.gitignore | git忽略列表，原工程中不包括 |
| /404.php | 404页面 |
| /addUserError.txt | 发送用户注册成功短信失败列表 |
| /autodeal.php | 自动发送订票成功短信脚本 |
| /favicon.ico | 网站图标 |
| /file.txt | 订票用户信息 |
| /index.php | 入口文件 |
| /PHPFetion.class.php | 一个使用PHP自动操作中国移动的飞信的进行发短信操作的类 |
| /README.md | 此说明文档 |
| /sendMessage.txt | 发送短信的队列 |
| /ticNotice.txt | 发送短信的队列 |
| /useradd.php | 发送用户注册成功短信脚本 |
| /xbsura.exe | xbsura自己写的一个利用C语言处理订票用户信息的软件 |

## 数据表说明

| 表 | 说明 |
| :---: | :---: |
| acinfo | 活动信息 |
| actype | 活动类型 |
| admin | 后台管理账户信息 |
| ticinfo | 学生订票信息 |
| uinfo | 学生账户信息 |

## 其他

此README有Ganlv于2017-03-23开始整理代码时创建，原来的代码中不包括此文件

代码漏洞很多，代码编写很随意，代码已不再维护。

整理时只删除了保密信息和个人敏感信息。

<http://piao.eeyes.net/>已于2017-03-02正式下线

## LICENSE

    Copyright 2012-2017 eeyes.net
    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at
    
        http://www.apache.org/licenses/LICENSE-2.0
    
    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
