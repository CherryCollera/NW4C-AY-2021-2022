
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" href="about.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="Stylesheet.css"/>
    <link rel="icon" type="image/x-icon" href="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637158138/ico/nullify_amnhjr.png">
    <link rel="stylesheet" type="text/css" href="userhome.css"/>
</head>
<style>
.aboutinfo{
    color: white;
	border-radius: 15%;
    cursor: pointer;
    width: 10vh;
    position: fixed;
    height: 10vh;
    font-size: 50px;
    font-weight: 600;
    bottom: 0;
    right: 0;
    transition: 350ms ease-in-out;
}

.aboutinfo:hover{
    color: black;
    transition: 350ms ease-in-out;
}
    h1{
        color: white;
        text-align: center;
        margin-top: 50px;
    }
    p{
        color: white;
        text-align:center;
    }
    h1{
	font-size: 40px;
}
.about_usP{
	width: 80%;
	font-size: 20px;
	margin: auto;
	text-align: justify;
	line-height: 40px;
}
.team_div{
	display: flex;
	align-items: center;
	justify-content: space-between;
	width: 80%;
	margin: auto;
}
.team_div img{
	width: 25%;
	border-radius: 1vh;
}
.team_info{
	height: 100% !important;
	display: flex;
	/*border: 1px solid red;*/
	flex-direction: column;
	align-items: flex-start;
	width: 73%;
}
.team_info > h1{
	margin-top: 0;
	font-size: 27px ;
}
.team_info > p{
	font-size: 16px;
	text-align: justify;

}
.socials{
	font-size: 27px ;
}
.socials > a {
	color: white;
	cursor: pointer;
	margin: auto 10px;
	transition: all .3s ease-in-out ;
}
.socials > a:hover{
	color: black;
	transition: all .3s ease-in-out ;
}
.rev{
	flex-direction: row-reverse;
}
.rev_info{
	align-items: flex-end;
}
.footer{
	background-color: gray;
}
.footer > center > h6{
	margin: auto;
	font-size: 15px ;
}
    </style>
<body>

<nav id="navigation" >
        <d class='userAdmtxt'><form action="productSearch.php" method="POST" class='navUSerHome'><input name='userSearch' placeholder='Search here...' type='text' /><button name='btnuserSearch' type='submit' ><i class="fas fa-search"></i></button></form></d>
        <img  title='Home'  class='navUL' onclick="window.location.href='main.php'" style='cursor:pointer' src='BMCP.png' class='userAdmtxt' alt='log'/>
        <ul id="log">
            <li><a class='regh' href="register.php">Register</a></li>
            <li><a class='logh' href="log-in.php">Log-in</a></li>
        </ul>
    </nav>
    <h1>About</h1>
    <p class="about_usP">Bataan Clothing Management Portal is a website created for promoting and selling local clothing brands in Bataan. With this website, business owners or sellers can create accounts and post their products so that the registered customer can view and buy their products.</p>
    <br/>
    <h1>Team</h1>
    <div class="team_div" title="Justin Escultura">
        <img src="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637358071/assets/escultura_zcmqne.jpg" alt="sc" />
        <div class="team_info">
            <h1>Justin Escultura</h1>
            <p> Lead Programmer </p>
            <p>The lead programmer of this project. While studying Information Technology in Bataan Peninsula State University, he gained knowlegde about coding specially in web development. He created this website as a part of his college and used it to improve more his knowledge about web developing.</p>
            <div class="socials">
                <a href="https://www.facebook.com/Dyastenn/" target="_blank" rel="noreferrer" ><i class='fab fa-facebook-square'></i></a>
                <a href="https://twitter.com/jstnescltra/" target="_blank" rel="noreferrer" ><i class='fab fa-twitter-square'></i></a>
                <a href="https://www.instagram.com/jas7iin/" target="_blank" rel="noreferrer" ><i class='fab fa-instagram-square'></i></a>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="team_div rev" title="Mark Paulo Layug">
        <img src="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637358071/assets/layug_nog9ol.jpg" alt="sc" />
        <div class="team_info rev_info">
            <h1>Mark Paulo Layug</h1>
            <p>The designer of this team. He is the artistic one in our team since he grew up doing sketches. With his dream to become a digital artist he used to follow graphic artist online to gain more knowledge about graphic design. Now, he used his knowledge to complete this project.</p>
            <div class="socials">
                <a href="https://www.facebook.com/markpaulo.nullifysc/" target="_blank" rel="noreferrer" ><i class='fab fa-facebook-square'></i></a>
                <a href="https://www.instagram.com/mynameismarkpauloooo/" target="_blank" rel="noreferrer" ><i class='fab fa-instagram-square'></i></a>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
<div class="team_div" title="Hermie Imperial">
        <img src="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637358070/assets/imperial_u7vrul.jpg" alt="sc" />
        <div class="team_info">
            <h1>Hermie Imperial</h1>
            <p>The leader of this team. With her leading skills, she always looks after the team members and split the work base on our skills. With her knowledge, we successfully created the chapters of this project. With her help, the team united and worked together to finish this project.</p>
            <div class="socials">
                <a href="/" target="_blank" rel="noreferrer" ><i class='fab fa-facebook-square'></i></a>
                <a href="/" target="_blank" rel="noreferrer" ><i class='fab fa-twitter-square'></i></a>
                <a href="/" target="_blank" rel="noreferrer" ><i class='fab fa-instagram-square'></i></a>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
      
    <div class="team_div rev" title="Myckel Lozano">
        <img src="https://res.cloudinary.com/bcmp-uploader/image/upload/v1637358070/assets/lozano_pb7z3n.jpg" alt="sc" />
        <div class="team_info rev_info">
            <h1>Myckel Lozano</h1>
            <p>The documentation manager of the team. He is the one that documented the whole project. With his knowledge, he also helped with designing and the creation of the chapters. With his help, the other members finished their activities and work in due time.</p>
            <div class="socials">
                <a href="https://www.facebook.com/myckel.lozano" target="_blank" rel="noreferrer" ><i class='fab fa-facebook-square'></i></a>
                <a href="https://twitter.com/myckellll" target="_blank" rel="noreferrer" ><i class='fab fa-twitter-square'></i></a>
                <a href="https://www.instagram.com/myckellll_/" target="_blank" rel="noreferrer" ><i class='fab fa-instagram-square'></i></a>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>

    <div>
        <div title='About' ><a href="about.php" class='aboutinfo fixd' id='info' name='info' ><i class='fas fa-info-circle'></i></a>
    </div>

</body>
<footer class="footer">
<br/>
            <center>
                    <h3>© Copyright - Bataan Clothing Management Portal : BCMP (2021) All Rights Reserved.</h3>
                    <h6>Capstone Project - Group VI</h6>   
            </center>
<br/><br/>
</footer>
    
</html>