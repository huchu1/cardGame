<?php 
    header('Access-Control-Allow-Origin:*');
    header("Access-Control-Allow-Credentials", "true");
    header('Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
    header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');

    $json = json_decode(file_get_contents('php://input'), true);

    // 서버 ip만 허용
    if (!preg_match("/^192.168.1.48/", $_SERVER['REMOTE_ADDR']) && !preg_match("/^::1/", $_SERVER['REMOTE_ADDR'])) {
        echo 0;
    } else {
        $dbHost = "192.168.1.113:3307";      
        $dbName = "web";     
        $dbUser = "root";       
        $dbPass = "rlawjdaks1!Q";  
    
        $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO  `card` (user_id, score) VALUES (:val1, :val2);"; 
        $stmt = $pdo->prepare($query); 
        $stmt->bindValue(':val1', $json["id"], PDO::PARAM_INT); 
        $stmt->bindValue(':val2', $json["score"], PDO::PARAM_STR);  
        $stmt->execute();
        echo 1;
    }
?> 