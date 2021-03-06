<!DOCTYPE html>
<?php
	if (session_status() == PHP_SESSION_NONE) session_start();

	$_SESSION['ismobile'] = false;
	$hassbs;
	$showemail;

	if(isset($_SESSION['hassbs']) && $_SESSION['hassbs']){
		$hassbs = true;
	} else if (isset($_SESSION['hassbs']) && $_SESSION['hassbs'] === false){
		$hassbs = false;
		$showemail = true;
	} else {
		$showemail = false;
		$hassbs = false;
	}
?>

<html style="scroll-behavior: smooth">
	<head>

		<link rel="stylesheet" type="text/css" href="css/slideup.css">
		<link rel="stylesheet" type="text/css" href="css/sageata.css">
		<link rel="stylesheet" type="text/css" href="css/basics.css">
		<link rel="stylesheet" type="text/css" href="css/footer.css">
		<link rel="stylesheet" type="text/css" href="css/progressbar.css">
				  
		<?php include 'elements/header.php'; ?>

		<!-- <?php
			if($hassbs || $showemail){
				echo " <script>
				function Scrolldown() {
					window.location.hash = '#wrapper-registration';
				}

				window.onload  = Scrolldown;
				</script>
				";
			}
			
		?> -->

		<script>
			function validateForm(){
				var email = document.forms["newsletter"]["email"].value;
				const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				var isemail = re.test(String(email).toLowerCase());
				var message = document.getElementById('message');

				if(!isemail){
					document.getElementById('message').innerHTML = 'Please enter a valid email address';
					return false;
				}
			}
		</script>

		<style>
			#banner-homepage{
				position: absolute; 
				top:0;
				width:100%;
				height:100%; 
				background: url(pictures/lamp.gif); 
				background-size: cover;
				background-position: center center;
				/* background-blend-mode: hue; */
				/* transform: rotate(90deg); */
				/* filter: grayscale(100%); */
				filter: blur(15px) hue-rotate(300deg);
			}
			.wrapper-bulina{
				position: relative;
				display: inline-block;
				width: 20%;
				height: 100%;
				background-color: transparent;
				/* margin-left: -0.4%; */
				/* border: 1px  solid blue; */
			}
			.wrapper-bulina .title{
				font-family: 'Khand', sans-serif;
				font-size: 2vw;
				color: white;
				position:absolute;
				right: 0;
				top: 0;
				width: 65%;
				text-align: left;
				margin-top: 7%;
			}
			.buline-homepage{
				position: absolute;
				z-index: 100;
				top: 0;
				width: 6vw;
				height: 6vw;
				left: 0%;
				background-color: #d222d2;
				border-radius: 50%;
				font-size: 1.2vw;
			}
			.wrapper-lists{
				position: absolute;
				z-index: 100;
				bottom: 0;
				width: 100%;
				height: 70%;
				background-color: transparent;
				overflow-y: scroll;
				scrollbar-width: none;
			}
			.wrapper-lists::-webkit-scrollbar{
				display: none;
			}
			.wrapper-registration #href{
				text-decoration: underline; color: black;
			}
			.wrapper-registration #href:hover{
				color: #00ff16;
			}
			#wrapper-registration-buttons a{
				position:absolute; 
				top:0%;  
				/* transform: translate(0%, -50%);  */
				/* height: 20%; 
				width: 8%;  */
				border: 0.4vh solid #00ff16; 
				border-radius:2vw;
				font-size: 3vh;
				background-color:#340634;
				color:white;
				height:80%; width:30%; border-radius:20px; font-size: 3vh;	background-color:#340634;
                transition: all 500ms ease; 
			}
			#wrapper-registration-buttons a:hover{
				color:white;
				border: 0.5vh solid #00ff16; 
				cursor:pointer;
				background-color: transparent;
                transition: all 500ms ease; 
			}
			.registration-button{
				position:absolute; 
				top:0%;  
				   transform: translate(0%, -50%); 
				   height: 20%; 
				   width: 8%; 
				border: 0.4vh solid #00ff16; 
				border-radius:2vw;
				font-size: 3vh;
				background-color:#340634;
				color:white;
			}
			.registration-button:hover{
				color:white;
				border: 0.5vh solid #00ff16; 
				cursor:pointer;
				background-color: transparent;
			}
			.registration-button:hover div{
				color:white;
				cursor:pointer;
			}
		</style>
	</head>

	<body id="home" style="background-color: #340634; margin: 0px; overflow-x:hidden;" onload="updateTimeline();">

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
    
		<div style="width: 100vw; height: 100vh; overflow: hidden">
			<div id="banner-homepage"></div>
			<div class="text-centrat" style="font-size: 1.5vw; width:100%; color: white; top:15%"> The Online Hackathon</div>
			<div class="text-centrat" style="font-size: 2.6vw; width:100%; color: white; font-family: 'Montserrat', sans-serif;"> Join us in the quest for building a <span style="mix-blend-mode: difference; color: white"> better </span> Bucharest! </div>
			<img src="pictures/LogoUTEAlb.png" style="z-index: 110; position: absolute; height:30%; top: 30%; left: 50%; transform: translate(-50%, -50%); mix-blend-mode:difference;" alt="UPtown Ecothon">
			<div style="background-color: transparent; width: 100%; height: 40%; bottom:0%; z-index:100; position: absolute; margin-left:1vw;">
				<div class="wrapper-bulina" style="margin: 0">
					<div class="buline-homepage" onmouseover="fadeicon(this)" onmouseleave="appearicon(this)">
						<a href="info.php">
							<div class="text-centrat" style="color: white; opacity: 0; z-index: 105;">Info</div>
							<img class="icon" id="info" src="ute-icons/calendar.svg" alt="Info">
						</a>
					</div>
					<div class="title">Info</div>
					<div class="wrapper-lists">
						<ul style="font-family: 'Montserrat', sans-serif; font-weight: 400; color: white; font-size: 1.2vw;">
							<?php echo $content['Buline']['Info']; ?>
						</ul>
					</div>
				</div><div class="wrapper-bulina">
					<div class="buline-homepage" onmouseover="fadeicon(this)" onmouseleave="appearicon(this)">
						<a href="aboutus.php">
							<div class="text-centrat" style="color: white; opacity: 0;">About Us</div>
							<img class="icon" id="contact" src="ute-icons/users.svg" alt="About Us">
						</a>
					</div>
					<div class="title">About Us</div>
					<div class="wrapper-lists">
						<ul style="font-family: 'Montserrat', sans-serif; font-weight: 400; color: white; font-size: 1.2vw;">
							<?php echo $content['Buline']['About us']; ?>
						</ul>
					</div>
				</div><div class="wrapper-bulina">
					<div class="buline-homepage" onmouseover="fadeicon(this)" onmouseleave="appearicon(this)">
						<a href="problem.php">
							<div class="text-centrat" style="color: white; opacity: 0;">Got A Problem?</div>
							<img class="icon" id="help" src="ute-icons/help.svg" alt="Got A Problem?">
						</a>
					</div>
					<div class="title">Got A Problem?</div>
					<div class="wrapper-lists">
						<ul style="font-family: 'Montserrat', sans-serif; font-weight: 400; color: white; font-size: 1.2vw;">
							<?php echo $content['Buline']['Got a problem?']; ?>
						</ul>
					</div>
				</div><div class="wrapper-bulina">
					<div class="buline-homepage" onmouseover="fadeicon(this)" onmouseleave="appearicon(this)">
						<a href="event.php">
							<div class="text-centrat" style="color: white; opacity: 0;">Event</div>
							<img class="icon" id="event" src="ute-icons/book.svg" alt="Event">
						</a>
					</div>
					<div class="title">Event</div>
					<div class="wrapper-lists">
						<ul style="font-family: 'Montserrat', sans-serif; font-weight: 400; color: white; font-size: 1.2vw;">
							<?php echo $content['Buline']['Event']; ?>
						</ul>
					</div>
				</div><div class="wrapper-bulina">
					<div class="buline-homepage" onmouseover="fadeicon(this)" onmouseleave="appearicon(this)">
						<a href="sponsors.php">
							<div class="text-centrat" style="color: white; opacity: 0;">Our Sponsors</div>
							<img class="icon" id="sponsors" src="ute-icons/investment.svg" alt="Our Sponsors">
						</a>
					</div>
					<div class="title">Sponsors</div>
					<div class="wrapper-lists">
						<ul style="font-family: 'Montserrat', sans-serif; font-weight: 400; color: white; font-size: 1.2vw;">
							<?php echo $content['Buline']['Our sponsors']; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="wrapper-registration" id="wrapper-registration" style="position:relative; height: 50vh; width:100%; margin:0; background-color: #d222d2">
			<div style="position:relative; 
						left: 50%; 
						transform: translate(-50%, 0%);
						height: 20vh; width:90%; 
						border:0px solid black; 
						margin: 0vh 0vw -10vh 0vw;
						font-size:5vh;"> 
				<div class="text-centrat" style="border-bottom: 0.5vh dashed #00ff16">
					<?php echo $content['Registration']['Title']; ?>
				</div> 
			</div>
			
			<div style="position:relative;
						left: 50%; 
						transform: translate(-50%, 0%);
						height: 20vh; width:90%;
						border:0px solid black;
						margin: 0vh 0vw -10vh 0vw;font-size:2.5vh;"> 		
				<div class="subtitile text-centrat">
					<?php echo $content['Registration']['More']; ?>
					
				</div> 
			</div>

			<div id="wrapper-registration-buttons" style="position: absolute; bottom:0vh; height: 20vh; width:100%;" >
				<?php
					if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
						echo " 
						<a href='account.php' style='left:50%; transform:translateX(-50%); width:80%'> 
							<div class='text-centrat' style='text-decoration: none; color:white;'>
								Hei, " . $_SESSION['username'] . "!" . $content['Registration']['Loggedin'] . "
							</div>	
						</a>
						";
					} else {
						// echo "
						// <a href='registration.php' style='left:25%; transform:translateX(-25%)'> <div class='text-centrat' style='text-decoration: none; color:white;'>" . $content['Registration']['Register'] . "</div></a>
						// <a href='login.php' style='left: 75%; transform:translateX(-75%)'> <div class='text-centrat' style='text-decoration: none; color:white;'>" . $content['Registration']['Login'] . "</div></a>
						// '";
						echo " 
						<a href='login.php' style='left:50%; transform:translateX(-50%); width:80%'> 
							<div class='text-centrat' style='text-decoration: none; color:white;'>
								" . $content['Registration']['Stop'] . "
							</div>	
						</a>
						";
					}
				?>
				
			</div>

			<!-- <div id="wrapper-newsletter-buttons" style="position: absolute; bottom:-2vh; height: 20vh; width:100%;" >
					<?php 
					if($hassbs){
						echo "
							<div id='subscribe-btn' style='position:absolute; top:0%;left: 50%; transform:translate(-50%, 0%); height:80%; width:30%; border: 0.4vh solid #00ff16;	border-radius:2vw; font-size: 3vh;	background-color:#340634; color:white;'>
								<div class='text-centrat' style='text-decoration: none; color:white;'> 
									You have successfully subscribed to our newsletter ;D
								</div>
							</div>
						";
						// unset ($_SESSION['hassbs']);
						$showemail = false;
					} else if ($hassbs === false && $showemail) {
						echo "
						<form name='newsletter' method='POST' class='form' style='display:visible; position:absolute; height:100%; width:100%; left:0%;' onsubmit='return validateForm()' action='scripts/register_subscriber.php'>
							<input type='text' id='email' class='email' name='email' placeholder='your e-mail...' style='position: absolute; top:0%; left: 50%; transform: translate(-50%, -20%); background-color:transparent; border:0.4vh solid black; border-radius: 2vw; color:white; height:30%; width:60%; font-size:3vh; padding: 0.3vh 1vw 0.3vh 1vw'>
							<button type='submit' id='submit' class='registration-button' style='right:10%; height: 20%; width: 8%;'><div class='text-centrat'>Submit</div></button>
							<div type='text' id='message' name='message' style='position: absolute; top:40%; left: 50%; transform: translate(-50%, 0%); background-color:transparent; color:black; height:30%; width:60%; font-size:2vh; padding: 0.3vh 1vw 0.3vh 1vw; font-family:sans-serif'>";
						echo $_SESSION['subscribemsg'];
						echo "	</div>
						</form>

						<div id='subscribe-btn' class='registration-button' style='top:0%;left: 14%; transform:translate(-50%, 0%); height:20%; width:8%;' onclick='hideSubscribe()'>
							<div class='text-centrat' style='text-decoration: none; color:white;'>
								Back
							</div>
						</div>
						";
						$showemail = false;
						unset ($_SESSION['hassbs']);
					} else {
						echo "
						<form name='newsletter' method='POST' class='form' style='display:visible; position:absolute; height:100%; width:100%; left:100%;' onsubmit='return validateForm()' action='scripts/register_subscriber.php'>
							<input type='text' id='email' class='email' name='email' placeholder='your e-mail...' style='position: absolute; top:0%; left: 50%; transform: translate(-50%, -20%); background-color:transparent; border:0.4vh solid black; border-radius: 2vw; color:white; height:30%; width:60%; font-size:3vh; padding: 0.3vh 1vw 0.3vh 1vw'>
							<button type='submit' id='submit' class='registration-button' style='right:10%; height: 20%; width: 8%;'><div class='text-centrat'>Submit</div></button>
							<div type='text' id='message' name='message' style='position: absolute; top:40%; left: 50%; transform: translate(-50%, 0%); background-color:transparent; color:black; height:30%; width:60%; font-size:2vh; padding: 0.3vh 1vw 0.3vh 1vw; font-family:sans-serif'>
							    	</div>
						</form>

						<div id='subscribe-btn' class='registration-button' style='top:0%;left: 50%; transform:translate(-50%, 0%); height:80%; width:30%;' onclick='showSubscribe()'>
							<div class='text-centrat' style='text-decoration: none; color:white;'>
								Subscribe
							</div>
						</div>
						";
					}
				?>				
			</div>  -->
		</div>

		<div style="position:relative; height: 20vh; width: 100%; border:0px solid black; margin: 3vh 0vw -10vh 0vw;font-size:5vh;"> <div class="text-centrat" style="border-bottom: 0.5vh dashed #00ff16; color:white">Helpful Timeline =D</div> </div>

		<div class="sectiune-timeline" id="timeline">
			<div class="timeline">
				<div class="progress"></div>
				
				<div class="milestone" style="left: 0.5%;" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['1 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][1]; ?> </div>
				</div>

				<div class="milestone" style="top:50%; left: 20%; transform: translate(-20%, -50%);" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['2 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][2]; ?> </div>
				</div>

				<div class="milestone" style="top:50%; left: 40%; transform: translate(-40%, -50%);" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['3 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][3]; ?> </div>
				</div>

				<div class="milestone" style="top:50%; left: 60%; transform: translate(-60%, -50%);" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['4 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][4]; ?> </div>
				</div>

				<div class="milestone" style="top:50%; left: 80%; transform: translate(-80%, -50%);" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['5 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][5]; ?> </div>
				</div>

				<div class="milestone" style="right: 0.5%;" onmouseover="showMeaning(this)" onmouseleave="hideMeaning(this)">
					<div class="text-centrat main"><?php echo $content['Timeline']['6 Title']?></div>
					<div class="text-centrat meaning" style="opacity: 0;"><?php echo $content['Timeline'][6]; ?> </div>
				</div>
			</div>

		</div>

	
		<?php include "elements/footer.html"; ?>	

		<script>
			

			function fadeicon(elem) {
            var icon = elem.getElementsByClassName('icon')[0];
            var text = elem.getElementsByClassName('text-centrat')[0];

            transitions.fadeOut(icon, tweenFunctions.easeOutExpo, 400);

            transitions.fadeIn(text, tweenFunctions.easeInExpo, 400);
			}

			function appearicon(elem) {
				var icon = elem.getElementsByClassName('icon')[0];
				var text = elem.getElementsByClassName('text-centrat')[0];

				transitions.fadeOut(text, tweenFunctions.easeOutExpo, 400);

				transitions.fadeIn(icon, tweenFunctions.easeInExpo, 400);

			}

			function showMeaning(elem){
				var main = elem.getElementsByClassName("main")[0];
				var meaning = elem.getElementsByClassName("meaning")[0];

				transitions.resize2D(new Dimension(elem, 30, "vh"),
                new Dimension(elem, 30, "vh"),
                tweenFunctions.easeOutQuad,
				400);

				transitions.fadeOut(main, tweenFunctions.easeOutExpo, 400);

				transitions.fadeIn(meaning, tweenFunctions.easeInExpo, 400);

			}
			function hideMeaning(elem){
				var main = elem.getElementsByClassName("main")[0];
				var meaning = elem.getElementsByClassName("meaning")[0];

				transitions.resize2D(new Dimension(elem, 12, "vh"),
                new Dimension(elem, 12, "vh"),
                tweenFunctions.easeInQuad,
				400);
				
				transitions.fadeOut(meaning, tweenFunctions.easeOutExpo, 400);

				transitions.fadeIn(main, tweenFunctions.easeInExpo, 400);
			}

			var wrprRegBtn = document.getElementById('wrapper-newsletter-buttons');			
			var subscribe = wrprRegBtn.getElementsByClassName('registration-button')[1]; 
			var subscribe_text = subscribe.getElementsByClassName('text-centrat')[0];
			var email = wrprRegBtn.getElementsByClassName('email')[0];
			var submit = wrprRegBtn.getElementsByClassName('registration-button')[0];
			var form = wrprRegBtn.getElementsByClassName('form')[0];

			function showSubscribe(){
				transitions.resize2D(
					new Dimension(subscribe, 8, "percent"),
               		new Dimension(subscribe, 20, "percent"),
                	tweenFunctions.easeOutExpo,
					700);
				transitions.slide2D(
					new Dimension(subscribe, 14, "percent"),
					new Dimension(subscribe, 0, "percent"),
					tweenFunctions.easeOutExpo,
					700);

				subscribe_text.innerHTML = "Back";

				transitions.slide2D(
					new Dimension(form, 0, "percent"),
					new Dimension(form, 0, "percent"),
					tweenFunctions.easeOutExpo,
					700);

				subscribe.setAttribute('onclick', 'hideSubscribe()');
					 
			}

			function hideSubscribe(){
				transitions.resize2D(
					new Dimension(subscribe, 30, "percent"),
               		new Dimension(subscribe, 80, "percent"),
                	tweenFunctions.easeOutExpo,
					700);
				transitions.slide2D(
					new Dimension(subscribe, 50, "percent"),
					new Dimension(subscribe, 0, "percent"),
					tweenFunctions.easeOutExpo,
					700);
				subscribe_text.innerHTML = "Subscribe";
				

				transitions.slide2D(
					new Dimension(form, 100, "percent"),
					new Dimension(form, 0, "percent"),
					tweenFunctions.easeOutExpo,
					700);

				subscribe.setAttribute('onclick', 'showSubscribe()');
					 
			}

			function updateTimeline(){
				//Pentru cei curiosi, aici iau timpul actual
				var currentTime = new Date();
				var milestoneTimes = [];

				//VARS
				//Aici setez toate milestone-urile intr-un array (ca si format Date)
				milestoneTimes[0] = new Date('January 15, 2021 00:00:00');
				milestoneTimes[1] = new Date('January 26, 2021 00:00:00');
				milestoneTimes[2] = new Date('February 23, 2021 18:00:00');
				milestoneTimes[3] = new Date('February 25, 2021 00:00:00');
				milestoneTimes[4] = new Date('February 26, 2021 00:00:00');
				milestoneTimes[5] = new Date('February 26, 2021 18:00:00');
				//Astea sunt niste offset uri la progress bar pt ca cineva ~ehem~ nu le-a pus din colturi
				var offsetLeft = 5;
				var offsetRight = 5;

				//Asta e marimea maxima a progress bar-ului
				var maxWidth = 100 - offsetLeft - offsetRight;
				var progress = document.getElementById('timeline').getElementsByClassName('progress')[0];
				//Spatiul dintre 2 buline (in percentage) - o sa avem nevoie pentru ca intre fiecare 2 buline nu este aceeasi durata fizica de timp
				var step = maxWidth / (document.getElementById('timeline').getElementsByClassName('milestone').length - 1);
				var totalWidth = 0;

				//Pentru fiecare milestone, mai putin ultimul
				for(let i = 0; i < 5; i++){
					//Daca data actuala a trecut de respectivul milestone
					if(currentTime > milestoneTimes[i]){
						//Aplicam regula de 3 simpla: 'ms' = 'milestone'
						//	ms[i+1] - ms[i] (timpul dintre 2 buline) .................... step
						//	currTime - ms[i] (timpul de la bulina pana in prezent) ...... sectPercentage

						let sectTime = currentTime - milestoneTimes[i];
						let maxSectTime = milestoneTimes[i + 1] - milestoneTimes[i];
						//Also verificam sa nu fie mai mare decat maxSectTime
						let sectPercentage = Math.min(sectTime, maxSectTime) * step / maxSectTime;
						//Adunam la total
						totalWidth += sectPercentage;
					}
				}

				progress.style.width = offsetLeft + totalWidth + "%";
			}

		</script>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="javascript/bs-form.js"></script>
		
	</body>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-190242876-1">
	</script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-190242876-1');
	</script>

</html>