<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) session_start();

    // if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    //     header('Location: login.php');
    //     die();
    // }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

?>
<!-- Getting info from db -->
<?php
    try{
        $db = new SQLiDB();

        $fields = array();
        $participants = array();
        $teamID;

        $sql = "SELECT team_id FROM users WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id", $_SESSION["id"]);

        $stmt->execute();

        if($stmt){
            $ret = $stmt->fetch(PDO::FETCH_ASSOC);

            $teamID = $ret["team_id"]; 
            // echo "<script type='text/javascript'>alert(" . $ret["teamID"] . ");</script>";

            if($teamID!=99 && $teamID!=0){
                //get team name
                $sql = "SELECT * FROM teams WHERE id = :id LIMIT 1";
                $stmt = $db->prepare($sql);

                $stmt->bindParam(":id", $teamID);

                $stmt->execute();
                if($stmt){
                    $ret = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(isset($ret) && !empty($ret)){
                        // echo "<script type='text/javascript'>alert(" . $ret . ");</script>";
                        $fields["team_name"] = $ret["name"];
                    } else{
                        $fields["team_name"] = "No team!";
                    }
                } 

                // get members
                $sql = "SELECT * FROM users WHERE team_id = :id";
                $stmt = $db->prepare($sql);

                $stmt->bindParam(":id", $teamID);

                $stmt->execute();
                if($stmt){
                    // $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // $i=0;
                    foreach($stmt as $row) {
                        $participants[]= $row['username'];
                        // $i++;
                    }

                    // echo "<script type='text/javascript'>alert(" . $participants . ");</script>";

                    // if(isset($ret) ){
                    //     echo "<script type='text/javascript'>alert(" . $ret . ");</script>";
                    //     $participants = $ret;
                    // } 
                    // else {
                        // echo "<script type='text/javascript'>alert('you alone');</script>";
                        // $fields["participants"] = "Looks like you're on your own";
                    // }
                    
                }

                //TODO:add function that displays files currently uploaded

            } else {
                $fields["team_name"] = "No team!";
                $fields["participants"] = "Looks like you're on your own";
            }
        } else {
            echo "<script type='text/javascript'>alert('Team DOnt exist');</script>";

        }
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/basics.css">
        <?php
            if(isset($_GET['lang']) && $_GET['lang'] == 'en'){
                $lang = 'EN';
            }
            else{
                $lang = 'RO';
            }

            //CONTENT
            require_once $_SERVER['DOCUMENT_ROOT'] . '/config/dbconfig.php';

            try{
                $db = new ContentDB();

                $content = array();
                $content = $db->getContentsForPage('upload_solution.php', $lang);

                $db = null;
                unset($db);
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        ?>

        <link rel="shortcut icon" type="image/png" href="./ute-icons/FaviconUTE.png"/>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Khand&family=Montserrat:wght@300;400&display=swap" rel="stylesheet"> 

        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="robots" content="noindex">

        <title>Upload Solution - UPtown Ecothon</title>


        <style>
            .fileList, .fileSize{
                position: relative;
                margin-top: -3vh;
                font-size: 1.5vh;
                /* font-family: 'Montserrat', sans-serif; font-weight: bold; */
            }
            .fileSize{
                margin-bottom: 3vh;
            }
            .fileList ul{
                position: relative;
                margin-top: -1vh;
                margin-bottom: -3vh;
            } 
            .fileList li{
                font-size: 1.5vh;
                /* font-family: 'Montserrat', sans-serif; font-weight: bold; */
            }
            p{
                position: relative;
                margin-top: -3vh;
                margin-bottom: 3vh;
                display: inline;
                font-size: 1.5vh; 
            }
            * {
                font-family:'Khand', sans-serif;
                color: black;
            }
            label{
                position: relative;
                font-size: 2vh;
                width: 20%;
            }
            input, textarea, select{
                position:relative;
                margin: 0vh 0vw 3vh 0vw;
                border: 0.3vh solid #00ff16;
                border-radius: 20px;
                width:98%;
                right: 0px;
                background-color: transparent;
                height: 2vh;
                padding: 1%;
                font-size: 2vh;
            }
            button{
                position:relative;
                margin: 0vh 0vw 3vh 0vw;
                border: 0.3vh solid #00ff16;
                border-radius: 20px;
                width:100%;
                right: 0px;
                background-color: #340634;
                height: 5vh;
                padding: 1%;
                font-size: 2vh;
                color: white;
                transition: all 500ms ease;
            }
            button:hover{
                background-color: transparent;
                color: black;
                transition: all 500ms ease;
            }
            .msg{
                position:relative;
                margin: 0vh 0vw 3vh 0vw;
                border-radius: 20px;
                width:100%;
                right: 0px;
                background-color: #ffafc0;
                font-size: 2vh;
                text-align:center;
                padding: 1%;
            }#language {
                position: fixed;
                top: 0px;
                right: 0vw;
                margin: 1vw;
                height: 4vh;
                background-color: transparent;
                mix-blend-mode: difference;
                z-index: 104;
            }

            #language li {
                display: inline;
                font-family: 'Khand', sans-serif; font-weight: bold;
                font-size: 2vw;
                color: white;
                text-decoration: none;
            }

            #language li a {
                font-family: 'Khand', sans-serif; font-weight: bold;
                font-size: 2vw;
                color: white;
                text-decoration: none;
            }

            #language li a:hover {
                -webkit-filter: invert(50%);
                filter: invert(50%);
            }
            @media screen and (max-width:750px){
                label{
                    font-size: 3vw;
                }
                input, textarea, select{
                    margin: 0vh 0vw 1vh 0vw;
                    width:98%;
                    height: 3vh;
                    padding: 1%;
                    font-size: 3vw;
                }
                button{
                    margin: 0vh 0vw 1vh 0vw;
                    width:100%;
                    padding: 1%;
                    font-size: 3vw;
                }
                .msg{
                    margin: 0vh 0vw 1vh 0vw;
                    width:100%;
                    font-size: 3vw;
                    padding: 1%;
                }#language {
                    height: 8vh;
                    right: 2vw;
                }
                #language li {
                    font-size: 5vw;
                }
                #language li a {
                    font-size: 5vw;
                } .fileList, .fileSize{
                    margin-top: -1vh;
                    font-size: 2vw;
                    /* font-family: 'Montserrat', sans-serif; font-weight: bold; */
                }
                .fileSize{
                    margin-bottom: 1vh;
                }
                .fileList ul{
                    position: relative;
                    margin-top: 0vh;
                    margin-bottom: -3vh;
                } 
                .fileList li{
                    font-size: 2vw;
                    /* font-family: 'Montserrat', sans-serif; font-weight: bold; */
                }
                p{
                    position: relative;
                    margin-top: -1vh;
                    margin-bottom: 1vh;
                    display: inline;
                    font-size: 2vw; 
                }
            } 
              
            </style>
    </head>
    <body style="background-color: #340634; margin:0px; overflow-x:hidden">
        <div id="language">
            <ul>
                <li style="border-right: 0.2vw solid white;">
                    <a href="?lang=ro">
                    ro
                    </a>
                </li>
                <li style="padding-left: 0.4vw;">
                    <a href="?lang=en">
                    en
                    </a>
                </li>
            </ul>
        </div>

        <div class="page-title" style="position: relative; margin-top: 8vh; margin-bottom:3vh; width:100%; height: 8vh; background-color: transparent; font-size:4vw; z-index:70">
            <div class="text-centrat" style="color:white; text-decoration: underline dashed 0.5vh #00ff16")>
                <?php echo $content['Interface']['PageTitle']; ?>
            </div>
        </div>

        <div class="rounded-rect" style="position:relative; left:50%; transform:translateX(-50%); background-color:white; width:60%;">
            <h2>Team:</h2>
            <?php echo $fields["team_name"]; ?>

            <h2>Members:</h2>
            <?php 
                if(empty($participants) || !isset($participants)){
                    echo "Looks like you're on your own";
                } else {
                    for ($i = 0; $i < count($participants); $i++) {
                        echo $participants[$i] . ", ";
                    }
                }
            ?>
            
            <h2>Code files:</h2>
            <!--TODO: action="scripts/upload.php" -->
            <form method="post" enctype="multipart/form-data" onsubmit="return validateForm(this)" id="app">
                <div class="msg" style="display:none"></div>

                <label for="appfile">Select project files to upload:</label>
                <input type="file" name="appfile" id="appfile" class="file" multiple>
                <!-- <div id="appfiles" class="list"></div> -->
                <p>selected files:</p> <span class="fileList" >There are no files.</span> <br>
                <p>total size:</p> <span class="fileSize" >0</span>  <br>

                <label for="appurl">Or enter a git url:</label>
                <input type="text" name="appurl" id="appurl" class="url" onclick="makeAllGreen(this.parentElement)">

                <button type="submit">Submit</button>
            </form>

            <h2>Prezentation files files:</h2>
            <!-- TO DO: add action="scripts/upload.php" -->
            <form  method="post" enctype="multipart/form-data" onsubmit="return validateForm(this)" id="prez">
                <div class="msg" style="display:none"></div>

                <label for="prezfile">Select prezentation files to upload:</label>
                <input type="file" name="prezfile" id="prezfile" class="file" multiple onclick="makeAllGreen(this.parentElement)" onchange="updateList(this, document.getElementById('prezfiles'));">
                <!-- <div id="prezfiles" class="list"></div> -->
                <p>selected files:</p> <span class="fileList" >There are no files.</span> <br>
                <p>total size:</p> <span class="fileSize" >0</span>  <br>
               
                <label for="prezurl">Or enter a url for your online presentation:</label>
                <input type="text" name="prezurl" id="prezurl" class="url" onclick="makeAllGreen(this.parentElement)">

                <label for="moneysfile">Select financial plan files to upload:</label>
                <input type="file" name="moneysfile" id="moneysfile" class="moneysfile">

                <button type="submit">Submit</button>
            </form>
        </div>
        
        <script>
            // function updateList(input, output) {
            //     //var input = document.getElementById('');
            //     //var output = document.getElementById('fileList');
            //     var children = "";
            //     for (var i = 0; i < input.files.length; ++i) {
            //         children += '<li>' + input.files.item(i).name + '</li>';
            //     }
            //     output.innerHTML = '<ul>'+children+'</ul>';
            // }


            //functie luata de pe developer.mozilla slightly modified, now does what i want it to do
            var appfile_bytes;
            var prezfile_bytes;
            function updateSize(fileInput) {
                let nBytes = 0,
                    oFiles = fileInput.files,
                    nFiles = oFiles.length,
                    children = "";

                for (let nFileId = 0; nFileId < nFiles; nFileId++) {
                    nBytes += oFiles[nFileId].size;
                    children += '<li>' + oFiles.item(nFileId).name + '</li>';
                }               

                let sOutput = nBytes + " bytes";
                // optional code for multiples approximation (NOTE: i do not know exactly what is happenning here but the aproximaiton looks nice so ill leave it in)
                const aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"];
                for (nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                    sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple] + " (" + nBytes + " bytes)";
                }
                // end of optional code
               
                bytes = nBytes;
                
                fileInput.parentElement.getElementsByClassName("fileSize")[0].innerHTML = sOutput;
                fileInput.parentElement.getElementsByClassName("fileList")[0].innerHTML = '<ul>'+children+'</ul>';

                return nBytes;
            }

            document.getElementById("appfile").addEventListener("change", function(){
                appfile_bytes = updateSize(this);
            }, false);

            document.getElementById("prezfile").addEventListener("change", function(){
                prezfile_bytes= updateSize(this);
            }, false);

            //ye
            function validateForm(section){
                var isOK = true;

                //verifies stuff not empty
                var file = section.getElementsByClassName('file')[0];
                var url = section.getElementsByClassName('url')[0];

                var file_verif = (file.value.length == 0 || file==null) ? false : true;
                var url_verif = (url.value.length == 0 || url==null) ? false : true;
                
                if(!file_verif && !url_verif){
                    isOK = false;
                    section.getElementsByClassName('msg')[0].style.display = "block";
                    section.getElementsByClassName('msg')[0].innerHTML = "Please submit at least one method through which we can take a look at your code";
                    file.style.borderColor = "red";
                    url.style.borderColor = "red";
                }


                //verify file size does not exceeed 50mb?????????????(pt ca aparent POST iti limiteaza automat la 50mb) in the messiest way possible 
                if((section.getAttribute('id')==="app" && appfile_bytes>41943040) || (section.getAttribute('id')==="prez" && prezfile_bytes>41943040)){
                    section.getElementsByClassName('msg')[0].style.display = "block";
                    section.getElementsByClassName('msg')[0].innerHTML = "Your files must be under 200MB !";
                    file.style.borderColor = "red";
                    isOK = false;
                } 

                //verify has submitted financial plan, again horribly messy, like everything else
                if(section.getAttribute('id')==="prez"){
                    if(section.getElementsByClassName('moneysfile')[0]!==null && section.getElementsByClassName('moneysfile')[0].value.length==0){
                        isOK = false;
                        section.getElementsByClassName('moneysfile')[0].style.borderColor = "red";
                        section.getElementsByClassName('msg')[0].style.display = "block";
                        section.getElementsByClassName('msg')[0].innerHTML = "Please submit financial plan (and prezentation if you haven't done so)";
                    }
                }

                // return isOK; TODO: DONT FORGET TO UNCOMMENT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                return false;
            }

            function makeAllGreen(section){
                var inputs = section.querySelectorAll("input")
                for (i = 0; i < inputs.length; i++) {
                    // inputs[i].addEventListener('click', function() {
                        inputs[i].style.borderColor = "#00ff16";
                    // });
                }
            }
            
        </script>
    </body>
</html>