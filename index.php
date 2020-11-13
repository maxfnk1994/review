<html>
<head>
<Title>Review 2 - Database connection</Title>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Signin Template · Bootstrap</title>
  <link href="/css/datepicker.css" media="screen" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap.css" media="all" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap-theme.min.css" media="all" rel="stylesheet" type="text/css">
  <link href="/css/style.css" media="all" rel="stylesheet" type="text/css">
  <link href="/img/favicon.png" rel="shortcut icon" type="image/vnd.microsoft.icon">
  <!-- Scripts -->
  <!--[if lt IE 9]><script type="text/javascript" src="/js/html5shiv.js"></script><![endif]-->
  <!--[if lt IE 9]><script type="text/javascript" src="/js/respond.min.js"></script><![endif]-->
  <script type="text/javascript" src="/js/jquery.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
</head>
<nav class="navbar navbar-inverse navbar-fixed-top hidden-print" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li>
          <a class="nav-header" href="https://review2.azurewebsites.net/">
            Survey </a>
        <li>
          <a class="nav-header" href="/project.html">
            Dashboard </a>
        </li>
      </ul>
    </div>
    <!--/.nav-collapse -->
  </div>
</nav>
<body>

<img class="mb-4" src="./img/pwc.svg" alt="pwc" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Review #2 Max Franke</h1>
  <h3 class="h4 mb-4 font-weight-normal">Please fill out this survey:</h3>
  <br>
  <form method="post" action="?action=add" enctype="multipart/form-data">
    <div class="form-group">
      <label for="t_emp_id">Emp ID</label>
      <input type="text" class="form-control" id="t_emp_id" aria-describedby="t_emp_id" placeholder="Enter Emp ID">
    </div>
    <div class="form-group">
      <label for="t_name">Name</label>
      <input type="text" class="form-control" id="t_name" aria-describedby="t_name" placeholder="Enter Name">
    </div>
    <div class="form-group">
      <label for="t_education">Education</label>
      <input type="text" class="form-control" id="t_education" aria-describedby="t_education" placeholder="Enter your Education">
    </div>
    <div class="form-group">
      <label for="t_email">E-Mail adress</label>
      <input type="email" class="form-control" id="t_email" aria-describedby="t_email" placeholder="Enter your E-Mail">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

<?php
/*Connect using SQL Server authentication.*/
$serverName = "tcp:review2.database.windows.net,1433";
$connectionOptions = array("Database"=>"review2",
                           "UID"=>"admin_review2",
                           "PWD" => "Gievenbeck1!");
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn === false)
{
    die(print_r(sqlsrv_errors(), true));
}
if(isset($_GET['action']))
{
    if($_GET['action'] == 'add')
    {
        /*Insert data.*/
        $insertSql = "INSERT INTO empTable (emp_id,name,education,email)
                      VALUES (?,?,?,?)";
        $params = array(&$_POST['t_emp_id'],
                        &$_POST['t_name'],
                        &$_POST['t_education'],
                        &$_POST['t_email']);
        $stmt = sqlsrv_query($conn, $insertSql, $params);
        if($stmt === false)
        {
            /*Handle the case of a duplicte e-mail address.*/
            $errors = sqlsrv_errors();
            if($errors[0]['code'] == 2601)
            {
                echo "The e-mail address you entered has already been used.</br>";
            }
            /*Die if other errors occurred.*/
            else
            {
                die(print_r($errors, true));
            }
        }
        else
        {
            echo "Registration complete.</br>";
        }
    }
}

$sql = "SELECT * FROM empTable ORDER BY name";
$stmt = sqlsrv_query($conn, $sql);
if($stmt === false)
{
    die(print_r(sqlsrv_errors(), true));
}
if(sqlsrv_has_rows($stmt))
{
    print("<table border='1px'>");
    print("<tr><td>Emp Id</td>");
    print("<td>Name</td>");
    print("<td>education</td>");
    print("<td>Email</td></tr>");
     
    while($row = sqlsrv_fetch_array($stmt))
    {
         
        print("<tr><td>".$row['emp_id']."</td>");
        print("<td>".$row['name']."</td>");
        print("<td>".$row['education']."</td>");
        print("<td>".$row['email']."</td></tr>");
    }
    print("</table>");
}*/
?>
</body>
</html>