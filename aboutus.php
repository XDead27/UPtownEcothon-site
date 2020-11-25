
<!DOCTYPE html>
<html>
    <head>
        <title></title>

        <link rel="stylesheet" type="text/css" href="css/sageata.css">
        <link rel="stylesheet" type="text/css" href="css/twistycontent.css">
		<link rel="stylesheet" type="text/css" href="css/basics.css">


        <link href="https://allfont.net/allfont.css?fonts=agency-fb-bold" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 


        <?php 
            include "content/c_aboutus.php";
            $contentArray = array();
            $contentArray[] = $__DescEchipa;
            $contentArray[] = $__Contact;
            $contentArray[] = $__ThisSite;
        ?>

        <script src="javascript/tween-functions.js"></script>
        <script src="javascript/transitions.js"></script>

        <script>
            var content = <?php echo json_encode($contentArray); ?>;
        </script>
    </head>
    <body>
        <?php include "elements/sageata.html" ?>

        <div style="display: flex; width:100vw; height: 100vh">
            <div style="height:100vh; flex: 33.3%; background-color:peachpuff;"></div>
            <div style="height:100vh; flex: 66.6%; background-color:white;"></div>
        </div>

        <!-- <div id="bigcontent" class="bigcontent">
            <div id="bigtitle" class="btitle"></div>
            <div id="bcontent" class="bcontent"></div>
        </div> -->

        
        <div id="smallcontent1" class="smallcontent" style="top: 10%;">
            <div class="smallcontent-inner" style="z-index: 1">
                <div class="title-card">
                    <div class="title">Salut</div>
                </div>
                <div class="content-card">
                    <div class="content">aa</div>
                    <div class="expand-button" style="top: 80%; left: 50%; transform:translate(-50%, -50%);" onclick="expand(this);">Expand</div>
                </div>
            </div>
            <div id="bigcontent" class="bigcontent" style="opacity: 0;">
                <div id="bigtitle" class="btitle"></div>
                <div id="bcontent" class="bcontent"></div>
            </div>
        </div>

        <div id="smallcontent2" class="smallcontent" style="top: 37.5%;">
            <div class="smallcontent-inner" style="z-index: 1">
                <div class="title-card">
                    <div class="title">Salut</div>
                </div>
                <div class="content-card">
                    <div class="content">aa</div>
                    <div class="expand-button" style="top: 80%; left: 50%; transform:translate(-50%, -50%);" onclick="expand(this);">Expand</div>
                </div>
            </div>
            <div id="bigcontent" class="bigcontent" style="opacity: 0;">
                <div id="bigtitle" class="btitle"></div>
                <div id="bcontent" class="bcontent"></div>
            </div>
        </div>

        <div id="smallcontent3" class="smallcontent" style="top: 65%;">
            <div class="smallcontent-inner" style="z-index: 1">
                <div class="title-card">
                    <div class="title">Salut</div>
                </div>
                <div class="content-card" >
                    <div class="content">aa</div>
                    <div class="expand-button" style="top: 80%; left: 50%; transform:translate(-50%, -50%);" onclick="expand(this);">Expand</div>
                </div>
            </div>

            <div id="bigcontent" class="bigcontent" style="opacity: 0;">
                <div id="bigtitle" class="btitle"></div>
                <div id="bcontent" class="bcontent"></div>
            </div>
        </div>

        <script>
            var i_content = 0;
            var bigtitle = document.getElementsByClassName('btitle');
            var bigcontent = document.getElementsByClassName('bcontent');
            for(let i = 0; i < bigtitle.length; i++){
                bigtitle[i].innerHTML = content[i]['title'];
            }

            for(let i = 0; i < bigcontent.length; i++){
                bigcontent[i].innerHTML = content[i]['content'];
            }

            var smalltitles = document.getElementsByClassName('title');
            for(let i = 0; i < smalltitles.length; i++){
                smalltitles[i].innerHTML = content[i]['title'];
            }

            var smallcontents = document.getElementsByClassName('content');
            for(let i = 0; i < smallcontents.length; i++){
                smallcontents[i].innerHTML = content[i]['short-description'];
            }

            function expand(elem){
                var box = elem.parentElement.parentElement.parentElement;
                var expand = box.getElementsByClassName('bigcontent')[0];
                var small = box.getElementsByClassName('smallcontent-inner')[0];

                retractElements(expand);

                transitions.fadeOut(small, tweenFunctions.easeOutExpo, 200);
                transitions.fadeIn(expand, tweenFunctions.easeOutExpo, 200);

                transitions.scaleUniform(box, tweenFunctions.easeInExpo, 2.1, 500);
                transitions.slide2DPercentageParent(box, tweenFunctions.easeOutExpo, 1500, 70, 25);
            }

            function retractElements(elem){
                var expand = document.getElementsByClassName('bigcontent');
                var small = document.getElementsByClassName('smallcontent');

                for(let x of expand){
                    if(x !== elem)
                        transitions.fadeOut(x, tweenFunctions.easeOutExpo, 500);
                }

                for(let x of small){
                    x.style.left = "";
                    x.getElementsByClassName('smallcontent-inner')[0].style.opacity = 1;
                    x.style.scale = 1.0;
                    x.style.margin = "";
                }
            }
        </script>
    </body>
</html>