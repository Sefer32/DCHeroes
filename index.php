<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dc-heroes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_GET['heroId'])) {
  $heroId = $_GET['heroId'];
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Get all teams
$sql2 = "SELECT * from team";
$result2 = $conn->query($sql2);

//get specific hero from team
if(isset($_GET['teamId']))
{
    $sql = "SELECT * FROM hero WHERE teamId =  " . $_GET['teamId'];
}
else {
  $sql = "SELECT * FROM hero";
}
$result = $conn->query($sql);

//Get hero details
if (!isset($_GET['heroId'])) {
  $sql3 = "SELECT * from hero";
}
else {
    $sql3 = "SELECT * from hero WHERE heroId = " . $_GET['heroId'];
}
$result3 = $conn->query($sql3);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Dc Univserse. - The bests comics">
	<link rel="stylesheet" type="text/css" href="css/style.css">
  	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link rel="icon" href="images/dc-logo.png" type="image/png">
	<title>Dc Universe</title>
</head>
<body>
	<header>
  <img src="images/dc-logo.png" width="100px" height="100px;" id="img-logo"><div class="logo"><a id="a_logo" href="index.php?teamId=1" style="text-decoration:none; font-family:verdana;">
  			Heroes
  		</a></div>
		</header>
		<div id="main-container">
		<div id="left-container">
		<nav>
			<h1>Teams</h1>
			<ul>
        <?php
          while($row2 = $result2->fetch_assoc()) {
         ?>
				     <li><a href="index.php?teamId=<?php echo $row2['teamId'];?>" style="text-decoration:none;"><?php echo $row2["teamName"]; ?></a></li>
        <?php
          }
        ?>
      </ul>
		</nav>
	</div>
	<div id="center-container">
    <h1>Heroes</h1>
		<?php
if ($result->num_rows > 0) {
  while($row3 = $result->fetch_assoc()) {

                  ?>
		<div class="hero-container">
			<div class="hero-image"><img height="200px" width="130px;" src="./<?php echo $row3["heroImage"]; ?>.jpg"></div>
			<div class="hero-description"><h3><?php echo $row3["heroName"]; ?></h3>
			<p><?php echo substr($row3["heroDescription"], 0, 80) . "..."; ?></p>
			<div class="button-hero1"><ul style="text-decoration:none;"><li style="text-decoration:none;"><a  style="text-decoration:none;" href="index.php?teamId=<?php echo $row3['teamId']; ?>&heroId=<?php echo $row3['heroId']; ?>" style="font-size:15px">More info..</a></li></ul></div></div>
		</div>
		<?php

					             }

					             }
					             else {
					                 echo "No results";
					             }

					         ?>
	</div>
	<div id="right-container">
    <?php
        if(isset($heroId)) {
     ?>

    <h1>Description</h1>
    <div class="right-box">
      <?php
        while($row3 = $result3->fetch_assoc()) {
       ?>
        <div class="top-part">
          <div class="mid-part-image">
            <img class="hero-image-round" height="200px" width="130px;" src="./<?php echo $row3["heroImage"]; ?>.jpg">
          </div>
          <div class="info-box">
            <h2>Info</h2>
            <p>
            <?php echo $row3['heroDescription']; ?>
            </p>
            <h2>Powers</h2>
            <ul>
              <li><?php echo $row3['heroPower']; ?></li>
            </ul>
            <?php
              }
            ?>
          </div>
          <h2>Rate your hero</h2>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="frmRate">
              <h4>Rating</h4>
              <div class="rate">
                <input type="radio" id="rating10" name="rating" value="10" />
                <label class="lblRating" for="rating10" title="5 stars"></label>


                  <input type="radio" id="rating8" name="rating" value="8" />
                  <label class="lblRating" for="rating8" title="4 stars"></label>



                  <input type="radio" id="rating6" name="rating" value="6" />
                  <label class="lblRating" for="rating6" title="3 stars"></label>


                  <input type="radio" id="rating4" name="rating" value="4" />
                  <label class="lblRating" for="rating4" title="2 stars"></label>


                  <input type="radio" id="rating2" name="rating" value="2" />
                  <label class="lblRating" for="rating2" title="1 star"></label>


                  <input type="radio" id="rating0" name="rating" value="0" />
                  <label class="lblRating" for="rating0" title="No star"></label>
              </div>

              <div class="review">
                <h4>Review</h4>
                <textarea class="text-area" rows="4" cols="50" name="comment" form="usrform">
Enter text here...</textarea>
              </div>
              <div class="divSubmit">
                <input type="submit" name="submitRating" value="Rate Hero"/>
                <input type="hidden" name="heroId" value="<?php echo $heroId; ?>"/>
              </div>
          </form>
          </div>

        </div>
        <?php
      } else {
        echo "please select a superhero";
      }
        ?>
    </div>

	</div>
</div>
</body>
</html>
