
<?php
	include 'conn.php';

	$issue_id=$row['Issue_id'];
	$mid=$row['Mid'];
	$name=$row['Name'];
	$bid=$row['Bid'];
	$bname=$row['Bname'];
	$claim_return_id = $row['claim_return_id'];
	$validreturndate=$row['validreturndate'];
	

//Example 04

//Vulnerable code

	/* $claim_return_id=$_GET['claim_return_id'];
	 $result=$mysqli->query("SELECT * FROM claimreturn where claim_return_id='$claim_return_id'");
	 */

//Modified code

    $claim_return_id = strip_tags($_GET['claim_return_id']);
    $claim_return_id = $mysqli->real_escape_string($claim_return_id);

    $result = $mysqli->query("SELECT * FROM claimreturn where claim_return_id='$claim_return_id'");
//Modified code end

	
	while ($row=$result->fetch_array())
	{
	$issue_id=$row['Issue_id'];
	$mid=$row['Mid'];
	$name=$row['Name'];
	$bid=$row['Bid'];
	$bname=$row['Bname'];
	$claim_return_id = $row['claim_return_id'];
	$validreturndate=$row['validreturndate'];
	$validreturndate1=new DateTime($row['validreturndate']);
		$returndate=new DateTime(date('Y-m-d'));
		$diff=date_diff($returndate,$validreturndate1);
		$days=$diff->d;

//Example 1

//vulnerable code

	//insert requestclaim record into return table

	/*$sql=$mysqli->query("INSERT INTO returnbook(Issue_id,claim_return_id,Mid,Name,Bid,Bname,validreturndate,Return_date,diff)
	   VALUES('$issue_id','$claim_return_id','$mid','$name','$bid','$bname','$validreturndate',now(),'$days')");
     
	$result=$mysqli->query($sql);

	*/

//modified 
	$stmt = $mysqli->prepare("INSERT INTO returnbook(Issue_id,claim_return_id,Mid,Name,Bid,Bname,validreturndate,Return_date,diff) VALUES (?,?,?,?,?,?,?,NOW(),?)");
    $stmt->bind_param("sssssssd", $issue_id, $claim_return_id, $mid, $name, $bid, $bname, $validreturndate, $days);
    $stmt->execute();
//Modified code end
	
     }
	 
	
	 
	 
	$sql2=$mysqli->query("update member set Book1=NULL where Mid='$mid'");
	
	$sql3=$mysqli->query("DELETE FROM claimreturn WHERE claim_return_id='$claim_return_id'"); 
	
	$sql4=$mysqli->query("update book set Availability='yes' where Bid='$bid'");
//inser into return store


$result=$mysqli->query("SELECT * FROM returnbook where claim_return_id='$claim_return_id'");
	while ($row=$result->fetch_array())
	{
    $return_id=$row['Return_id'];
	$issue_id=$row['Issue_id'];
	$mid=$row['Mid'];
	$name=$row['Name'];
	$bid=$row['Bid'];
	$bname=$row['Bname'];
	$validreturndate=$row['validreturndate'];
    $returndate=$row['Return_date'];
	
	$sql=$mysqli->query("INSERT INTO returnstore(Return_id,Issue_id,Bid,Bname,Mid,Name,validreturndate,Return_date,diff)
	   VALUES('$return_id','$issue_id','$bid','$bname','$mid','$name','$validreturndate',now(),'$days')");
     
	$result=$mysqli->query($sql);
	
     }


//delete returnclaim record	 and return record
$sql1=$mysqli->query("DELETE FROM claimreturn WHERE claim_return_id='$claim_return_id'"); 
    $result1=$mysqli->query($sql1);

$sql1=$mysqli->query("DELETE FROM returnbook WHERE claim_return_id='$claim_return_id'"); 
    $result1=$mysqli->query($sql1);

$sql1=$mysqli->query("DELETE FROM issuebook WHERE Issue_id='$issue_id'"); 
    $result1=$mysqli->query($sql1);
	
	//create fine record


	header ('location:admin.php'); 



?>