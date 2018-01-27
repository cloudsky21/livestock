<?php
require_once 'connection/conn.php';

if ($_FILES["fileName"]["type"] == "application/pdf" )
  {
  //do the error checking and upload if the check comes back OK
         switch ($_FILES['fileName'] ['error'])
          {  case 1:
                    print '<p> The file is bigger than this PHP installation allows</p>';
                    break;
             case 2:
                    print '<p> The file is bigger than this form allows</p>';
                    break;
             case 3:
                    print '<p> Only part of the file was uploaded</p>';
                    break;
             case 4:
                    print '<p> No file was uploaded</p>';
                    break;
          }

    $temp = explode(".",$_FILES['fileName']['name']);
    $newfilename = $_POST['ids'].'RSBSA'.'.'.end($temp);
		move_uploaded_file($_FILES["fileName"]["tmp_name"],
  		"../L/uploads/" . $newfilename);

    $ids = $_POST['ids'];
    $path = "../L/uploads/".$newfilename;
    $result = $db->prepare("UPDATE control2017 SET imagepath = ? WHERE idsnumber = ?");
    $result->execute([$path,$ids]);


  }
else
  {
  echo "Files must be PDF";
  }





?>