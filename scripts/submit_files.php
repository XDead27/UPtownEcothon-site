<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/captchacredentials.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/captchaconfig.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $uname = (isset($_POST['uname']) && !empty($_POST['uname'])) ? filter_var(trim($_POST["uname"]), FILTER_SANITIZE_SPECIAL_CHARS) : null;
        $passwd_verif = (isset($_POST['verif']) && !empty($_POST['verif'])) ? base64_decode($_POST['verif']) : null;
        $git_url = (isset($_POST['git_url']) && !empty($_POST['git_url'])) ? filter_var($_POST["git_url"], FILTER_SANITIZE_STRING) : null;
        $presentation_url = (isset($_POST['presentation_url']) && !empty($_POST['presentation_url'])) ? filter_var($_POST["presentation_url"], FILTER_SANITIZE_STRING) : null;

        try{
            $db = new SQLiDB();

            if($uname && $passwd_verif){
                $sql = "SELECT passwd, team_id FROM users WHERE username = :uname";
                $stmt =$db->prepare($sql);
    
                $stmt->bindParam(":uname", $uname);
    
                $stmt->execute();
                $ret = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if(!empty($ret)){
                    if($passwd !== $ret['passwd']){
                        echo "Invalid token!";
                        die();
                    }
            
                    $sql = "SELECT name FROM teams WHERE id = :id";
                    $stmt =$db->prepare($sql);
        
                    $stmt->bindParam(":id", $ret['team_id']);
        
                    $stmt->execute();
                    $ret = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!empty($ret) && checkFiles()) {
                        $filepaths = moveFiles($ret['team_id']);

                        //Upload to database
                        $sql = "SELECT * FROM uploads WHERE team_id = :team_id";
                        $stmt =$db->prepare($sql);

                        $stmt->bindParam(":team_id", $team_id);

                        $stmt->execute();
                        $ret = $stmt->fetch(PDO::FETCH_ASSOC);

                        if(empty($ret)){
                            $sql = "INSERT INTO uploads (team_id, user_modified) VALUES (:team_id, :uname)";
                        }
                        else{
                            $sql = "UPDATE uploads SET user_modified = :uname WHERE team_id = :team_id";
                        }

                        $stmt =$db->prepare($sql);

                        $stmt->bindParam(":team_id", $team_id);
                        $stmt->bindParam(":uname", $uname);

                        $stmt->execute();

                        if(isset($filepaths['appfile'])){
                            $app_filename = filter_var(basename($_FILES['appfile']['name']), FILTER_SANITIZE_SPECIAL_CHARS);
                            $app_path = $filepaths['appfile'];

                            $sql = "UPDATE uploads SET app_filename = :af, app_path = :ap WHERE team_id = :team_id";

                            $stmt =$db->prepare($sql);

                            $stmt->bindParam(":team_id", $team_id);
                            $stmt->bindParam(":af", $app_filename);
                            $stmt->bindParam(":ap", $app_path);

                            $stmt->execute();
                        }

                        if($presentation_url){
                            $sql = "UPDATE uploads SET prez_link = :url WHERE team_id = :team_id";

                            $stmt =$db->prepare($sql);

                            $stmt->bindParam(":team_id", $team_id);
                            $stmt->bindParam(":url", $presentation_url);

                            $stmt->execute();
                        }

                        if(isset($filepaths['presfile'])){
                            $prez_files_filename = filter_var(basename($_FILES['presfile']['name']), FILTER_SANITIZE_SPECIAL_CHARS);
                            $prez_files_path = $filepaths['presfile'];

                            $sql = "UPDATE uploads SET prez_files_filename = :pf, prez_files_path = :pp WHERE team_id = :team_id";

                            $stmt =$db->prepare($sql);

                            $stmt->bindParam(":team_id", $team_id);
                            $stmt->bindParam(":pf", $prez_files_filename);
                            $stmt->bindParam(":pp", $prez_files_path);

                            $stmt->execute();
                        }

                        if($git_url){
                            $sql = "UPDATE uploads SET app_git_url = :url WHERE team_id = :team_id";

                            $stmt =$db->prepare($sql);

                            $stmt->bindParam(":team_id", $team_id);
                            $stmt->bindParam(":url", $git_url);

                            $stmt->execute();
                        }

                        if(isset($filepaths['finplan'])){
                            $fin_plan_filename = filter_var(basename($_FILES['finplan']['name']), FILTER_SANITIZE_SPECIAL_CHARS);
                            $fin_plan_path = $filepaths['finplan'];

                            $sql = "UPDATE uploads SET fin_plan_filename = :af, fin_plan_path = :ap WHERE team_id = :team_id";

                            $stmt =$db->prepare($sql);

                            $stmt->bindParam(":team_id", $team_id);
                            $stmt->bindParam(":af", $fin_plan_filename);
                            $stmt->bindParam(":ap", $fin_plan_path);

                            $stmt->execute();
                        }
                    } else {
                        echo "Sorry, your file was not uploaded.";
                        http_response_code(403);
                    }

                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
            http_response_code(500);
        }

        
    }

    function checkFiles(){
        $uploadOk = true;
            
        if ($_FILES["appfile"]["size"] > 200000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = false;
        }

        //to add...

        return $uploadOk;
    }

    function moveFiles($team_name){
        $filepaths = array();

        $target_dir = $_SERVER['DOCUMENT_ROOT']. "../UTE-contest/uploads";

        if(file_exists($_FILES['appfile']['tmp_name'][0])) {
            $random_string = md5(rand());
            $target_file = $target_dir . $team_name . "_appfile_" . $random_string . "." . pathinfo($_FILES['appfile']['name'])['extension'];

            if (move_uploaded_file($_FILES["appfile"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["appfile"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                http_response_code(500);
                die();
            }
            $filepaths['appfile'] = $target_file;
        }

        return $filepaths;
    }

    function uploadToDatabase($db, $filepaths){
        

        
    }

?>