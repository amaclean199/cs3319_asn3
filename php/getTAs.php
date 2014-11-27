<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CS3319 Assignment 3</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="../js/bootstrap.js"></script>
</head>
<body>

  <?php
  include 'connectdb.php';
  $whichProf = $_POST["professors"];
  $whichCourse = $_POST["courses"];
  if ($whichProf != NULL) $toDisplay = $whichProf;
  else $toDisplay = $whichCourse;
  ?>
  <div class="container">
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <a href = "prof.php" type="button" class="btn btn-success navbar-btn navbar-left">Back</a>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <?php
    if ($whichProf != null)
    {
      $query = 'select t.firstname, t.lastname, t.studentnum, t.userid, t.type, t.image, t.headid from ta as t ' . 
      'where t.headid="' . $whichProf . '" union (select x.firstname, x.lastname, x.studentnum, x.userid, x.type, x.image, x.headid from ta as x where x.userid in (select c.studentid from' .
        ' cosupervises as c where c.superid="' . $whichProf . '"))';
    }
    else if ($whichCourse != null)
    {
      $query = 'select t.firstname, t.lastname, t.studentnum, t.userid, t.type, t.image, x.coursenum, c.coursenum FROM ta as t ' .
      'join assignedto as x on t.userid = x.studentid join course as c on x.coursenum = c.coursenum where x.coursenum = "' . $whichCourse . '"';
    }

    
    $result=mysqli_query($connection,$query);
    if (!$result) {
     die("database query2 failed. " . $connection->error);
   }
   ?>
   <h3>TA's for <?php echo $toDisplay; ?></h3>
   <table class="table">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Student Number</th>
        <th>Western ID</th>
        <th>Graduate Type</th>
        <th>Image</th>
        <?php require_once 'functions.php'; displayTypeHeader($whichProf); ?>
      </tr>
    </thead>
    <tbody>
      <?php require_once 'functions.php';
      while ($row=mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['firstname'] . '</td>';
        echo '<td>' . $row['lastname'] . '</td>';
        echo '<td>' . $row['studentnum'] . '</td>';
        echo '<td>' . $row['userid'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['image'] . '</td>';
        displayTypeInfo($row, $whichProf);
      }
      ?>
    </tbody>
  </table>
  <?php
  mysqli_close($connection);
  ?>
</div>
</body>
</html>