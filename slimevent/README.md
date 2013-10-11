SlimEvent
======

### 上线部署

1. 在index.php里设置连接数据库用户名和密码
2. 根据服务器环境，修改.htaccess里的RewriteBase和app/cfg/setup.cfg里的WEB_ROOT
3. mkdir temp static/kindeditor/attached
4. chmod -R 777 temp poster static/kindeditor/attached
5. 修改app/cfg/constant.cfg里的WEB_URL
6. 修改app/cfg/constant.cfg里的DEFAULT_PWD
7. 修改app/cfg/setup.cfg里的TOKEN_SALT和PWD_SALT
8. 设置app/cfg/setup.cfg里的DEBUG=0
9. 通过phpmyadmin导入数据库(仅结构)
10. 创建管理员用户：打开网站，选择学生登陆，登陆成功后，进入数据库，在users表里插入一条记录(name=“admin" "”nickname="管理员" group=“admin” 其余都复制学生的那条记录)，然后在admin表里插入一条相关记录。用户名：admin，密码：DEFAULT_PWD，登陆系统后，修改密码。


### 环境设定

为方便大家协同开发，请遵循如下设定

1. Fork 本仓库
2. 克隆仓库到本地，放置在Web服务器根目录下，保证能够用 http://localhost/slimevent/ 访问到
3. 保证本地的mysql server的root用户密码为空
4. 创建一个数据库 `slimevent` 
5. 开启`apache`的`mod_rewrite`模块，并将 `slimevent` 目录的 `AllowOverride` 设置为 `All`
6. 在 `slimevent` 目录下创建`temp`目录并将权限设置为777
7. 下载 [Dowloads](https://github.com/pureweber/slimevent/downloads) 页面中的 `google-api.tar` ，并将解压出来的 `google-api` 目录放在 `app/lib/` 目录下

### 程序框架

根目录下的 `app` 目录存放所有的后端代码，包括F3框架，各种第三方库，SlimEvent的MVC等。根目录下的 `static` 目录存放前端用到的css, js, image等静态组件。

根目录下的 `index.php` 是全局入口。根目录下的 `temp` 目录是用于存放由模板生成的动态代码的临时目录，应该在部署时手动创建，不需纳入版本控制。

app目录下的目录结构如下

* `actions` - MVC中的Controller ，主要的程序逻辑放在此处，此目录下的PHP类均应以 `SE` 开头，如 SEHome, SEEvent.
* `cfg` - 存放F3框架的配置文件，其中 `routes.cfg` 存放URL映射， `setup.cfg` 存放全局设置
* `lib` - F3框架的库和第三方库(如Google API Client, CAS Client等)
* `models` - MVC中的Model，封装对数据和抽象访问，此目录下的PHP类均应使用名词命名，如 `Account`
* `ui` - MVC中的View，界面模板文件

新增一个界面时，大致步骤如下

1. 在 `app/cfg/routes.cfg` 中增加一条URL映射，指定URL模式和对应的处理逻辑
2. 在 `app/actions/` 中增加一个Controller，或者在已有的Controller中增加一个方法
3. 在 `app/ui/` 中增加一个模板文件，定义界面
