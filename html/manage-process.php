<?php
$dir = "../modules/dbConnection/connect.php";
require ('../modules/dbConnection/dbConnect.php');

?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Processes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" href="../images/lara_rounded.png"/>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="../bootstrap/css/w3.css"/>
  <link rel="stylesheet" href="../bootstrap/css/footer.css"/>
  <link rel="stylesheet" href="../bootstrap/css/kl.css"/>
  <script src="../bootstrap/js/w3.js"></script>
  <script src="../bootstrap/js/jquery-3.2.1.slim.min.js"></script>
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/Chart.bundle.js"></script>
  <script src="../bootstrap/js/Chart.bundle.min.js"></script>
  <script src="../bootstrap/js/bootbox.min.js"></script>
  <script src="../bootstrap/js/kl.js"></script>

<!-- #region datatables files -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 
</head>
  
<body>

<nav class="w3-card navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <a class="navbar-brand" href="#"> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
 
      <li class="nav-item">
        <a class="nav-link" href="manage-kb.php">Knowledgebase</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="manage-process.php">Process</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-links.php">Links</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tm-tools.html">Tools</a>
      </li>
 
 
      <li class="nav-item">
             <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Add another Process</button>

      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
     <div class="input-group">
        <input type="text" autofocus="" id="searchbox" onKeyUp="searchKB()" class="form-control" placeholder="Search for anything...">
        <div class="input-group-append">
        <button class="btn btn-success" type="button">
        <img src="../images/icons/octicons-white/search-white.png" width="15" />
        </button>
        </div>
      </div>
    </form>

  </div>
</nav>
 
 
<br/>

<div class="container-fluid primary h-100" >
 
  <div class="row justify-content-center align-items-center">
    <div class="col-12  mx-auto card-clock">
    <br/>

      <div id="message" class="col-3 w3-card mx-auto p-1">
        <h3 class="display-5 code" align="center">
          <img src='../images/icons/facepalm.svg' height="50" height="50" />
          Nothing to load.</h3>
      </div>

    <div class="table-responsive">  
    <table align="center" class="table table-bordered" id="table">
      <thead>
        <th scope="col"  class="text-center" colspan="2">Action</th>
        <th scope="col">Category</th>
        <th scope="col">Level</th>
        <th scope="col">Title</th>
        <!--<th scope="col">Content</th>-->
      </thead>
      <tr style="overflow: auto;">
        <td id="aView" align="center"></td>
        <td id="aDelete" align="center"></td>
        <td id="tdCat" align="center"></td>
        <td id="tdLevel" align="center"></td>
        <td class="table table-striped" id="tdTitle"></td>
        <!--<td id="tdContent"></td>-->
      </tr>
    </table>

    </div>
    <br/>

    </div>
  </div> <!--end row-->
</div> <!--end container-->

<br/> 

<script>


 
$( document ).ready(function() {
var xmlhttp = new XMLHttpRequest();
var url = "../modules/process/process-list.php";
 xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
       loadAllProcess(myArr);
    }
}
//document.getElementById("tdID").innerHTML = "Loading, please wait...";
xmlhttp.open("GET", url, true);
xmlhttp.send();
 
});

function loadAllProcess(arr){
    var aView= "";
    var aDelete= "";
    var cat = "";
    var title = "";
    var level = "";
   // var content = "";
    var i;

  if(arr.length <=0) {
   showMessage("noContent");
  }
    else{
       showMessage("contentFound");
    for(i = 0; i < arr.length; i++) {
         aView += '<a href="view-process.html?id='+ arr[i].pID + '"  target="_blank">View</a><br>';
          aDelete += '<a href="-process.html?id='+ arr[i].pID + '"  target="_blank">Delete</a><br>';
         level += arr[i].pLevel + '<br>';

         cat += arr[i].pCategory + '<br>';
        
            title +=  
        arr[i].pTitle + '<br>';
    
       //     content += '<a href="' + arr[i].pDesc + '">' + 
      //  arr[i].pDesc + '</a><br>';
    }
      document.getElementById("aDelete").innerHTML = aDelete;
      document.getElementById("aView").innerHTML = aView;
      document.getElementById("tdCat").innerHTML = cat;
      document.getElementById("tdLevel").innerHTML = level;
      document.getElementById("tdTitle").innerHTML = title;
  //   document.getElementById("tdContent").innerHTML = content;
  }
}
 

/**
  Only display the table if there is content to show.
  Otherwise, display a message telling the user to add
  content.
  Edit method in kl.js
*/
 

function searchKB(){
   let cat; 
  var stext = document.getElementById("searchbox").value;

console.log("LOG: ../modules/process/process-list.php?pDesc="+stext);
  
var xmlhttp = new XMLHttpRequest();
var url = "../modules/process/process-list.php?pDesc="+stext;
console.log("URL: " + url);
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        displayResult(myArr);
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();

function displayResult(arr) {
    var cat = "";
    var title = "";
    var level = "";
    var i;
  if(arr.length <=0) {
   showMessage("noContent");
    // document.getElementById("tdContent").innerHTML = "";
  }
  else{
       showMessage("content");
    for(i = 0; i < arr.length; i++) {
 
    
            cat += '<a href="' + arr[i].pCategory + '">' + 
        arr[i].pCategory + '</a><br>';

            level += '<a href="' + arr[i].pLevel + '">' + 
        arr[i].pLevel + '</a><br>';
    
            title += '<a href="' + arr[i].pTitle + '">' + 
        arr[i].pTitle + '</a><br>';
    
          //  content += '<a href="' + arr[i].pDesc + '">' + 
     //   arr[i].pDesc + '</a><br>';
    }
     document.getElementById("tdCat").innerHTML = cat;
    document.getElementById("tdLevel").innerHTML = level;
    document.getElementById("tdTitle").innerHTML = title;
    // document.getElementById("tdContent").innerHTML = content;
  }
  }
}


function showAlert(){
var dialog = bootbox.dialog({
    message: '<p class="text-center">Great! New process added successfully.</p>',
    closeButton: true
});
// do something in the background
dialog.modal('hide');
}
 
</script>






<!--modal for add KB-->
 <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add a new process</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
             <div class="input-group mb-3">
              <div class="input-group-append">
              <span class="input-group-text">Category</span>
              </div>
              <select class="form-control" name="pCategory">
                <option>Technical</option>
                <option>Non-technical</option>
               </select>
             </div>

             <div class="input-group mb-3">
              <div class="input-group-append">
              <span class="input-group-text">Level</span>
              </div>
              <select class="form-control" name="pLevel">
                <option>1</option>
                <option>2</option>
               </select>
             </div>

             <div class="form-group">
             <div class="input-group mb-3">
              <div class="input-group-append">
               <span class="input-group-text">Title</span>
              </div>
              <input type="text" class="form-control" name="pTitle">
             </div>
            </div>

            <div class="form-group">
              <label for="comment">Process flow:</label>
              <textarea class="form-control" name="pDesc" rows="11" id="comment" required="" placeholder="Type the instructions here..."></textarea>
              <?php //echo  getenv("HOMEDRIVE"). getenv("HOMEPATH"); ?>
              
            </div>
              
      </div>
      <div class="modal-footer">
        <input type="submit" name="submit" class="btn btn-success" value="Submit">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
      <div class="container">
        <span class="text-muted"><code>Designed</code> and <code>Coded</code> by <code>KentLogic</code> for <code>KentLogic</code></span>
      </div>
    </footer>
 
 

<?php
date_default_timezone_set("Asia/Manila");
$date = Date('m-d-y h:i:sa');
if (isset($_POST["submit"])) {
 $stmt = $conn->prepare("INSERT INTO process (pCategory, pTitle, pDesc, pLevel, pCreatedBy, pCreateDate)
             VALUES (:pCategory, :pTitle, :pDesc, :pLevel, :pCreatedBy, :pCreateDate)");

$pCreatedBy = "Kent";

$stmt->bindParam(':pCategory', $_POST['pCategory']);
$stmt->bindParam(':pTitle', $_POST['pTitle']);
$stmt->bindParam(':pDesc', $_POST['pDesc']);
$stmt->bindParam(':pLevel', $_POST['pLevel']);
$stmt->bindParam(':pCreatedBy', $pCreatedBy);
$stmt->bindParam(':pCreateDate', $date);
 
try{
$stmt->execute(); 
    echo '<script language="javascript">';
    echo 'showAlert();';
    echo '</script>';
}
catch(PDOException $e)
    {
      echo '<script language="javascript">';
  echo 'alert("Zan nendesu... \n")';
  echo  'console.log('.$e->getMessage().');';
  echo '</script>';
    }

}
$conn = null;
?>

</body>
</html>


