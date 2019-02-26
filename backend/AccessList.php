<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
    $stmt = $pdo->prepare("select * from access");
    $stmt->execute();
    $access_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    function print_json($data){
        $arr = json_decode($data,true);
        foreach($arr as $v ){
            echo $v."<br>";
        }
    }
 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资源管理</title>
</head>
<body>
    <div id="container">
        <table>
            <caption>资源列表</caption>
            <tr>
                <td>资源ID</td>
                <td>名称</td>
                <td>urls</td>
                <td>操作</td>
            </tr>
            <?php if( count($access_arr) ): ?>
                <?php foreach($access_arr as $access): ?>
                     <tr>
                        <td><?php echo $access['access_id']; ?></td>
                        <td><?php echo $access['title']; ?></td>
                        <td><?php print_json($access['urls']); ?></td>
                        <td>
                            <a href="EditAccess.php?access_id=<?php echo $access['access_id']?>">资源设置</a>
                        </td>
                     </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>