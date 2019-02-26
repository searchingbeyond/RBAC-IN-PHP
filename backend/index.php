<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        a {
            font-size:3rem;
            padding-left:3rem;
        }
    </style>
</head>
<body>
    <div>
        <table>
            <tr>
                <td><a href="./UserList.php">用户列表</a></td>
                <td><a href="./RoleList.php">角色管理</a></td>
                <td><a href="./AccessList.php">权限管理</a></td>
            </tr>
            <tr>
                <td><a href="./AddUser.php">添加用户</a></td>
                <td><a href="./AddRole.php">添加角色</a></td>
                <td><a href="./AddAccess.php">增加资源</a></td>
            </tr>
        </table>
    </div>
</body>
</html>

<br><br><br><hr>
<h1 style="color:red">
    建议的测试过程：<br>
    <ol>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;先添加用户，需要记住user的id和name</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;然后添加角色</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;添加资源，并且为资源命名</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;在用户列表中为用户设置角色</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;先添加用户</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;进入角色管理，为角色添加可以获取的资源</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;访问/rbac/frontend/index.php，按照页面提示进行测试</li>
    </ol>
</h1>