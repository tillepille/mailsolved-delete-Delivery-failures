<html>
<header>
	<title>Delete Mail</title>
</header>
<body>
<?php

$emailUser = "user";
$emailPassword = "password";
$db = new PDO('db-server', 'db-user', 'db-password');
$dbTable = "_entries";
//DB Prepare
$dbStatement = $db->prepare("DELETE FROM $dbTable WHERE mail = ?");

$mbox = imap_open("{imap-server}INBOX", $emailUser, $emailPassword) or die("can't connect: " . imap_last_error());

$MC = imap_check($mbox);
$mCounter = 0;
// Fetch an overview for all messages in INBOX
$result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
// look at every mail
foreach ($result as $overview) {
    //mail number
    $msgNumber = $overview->msgno;
    echo "#".$msgNumber." ";
    //MIME Header
    $mimeHeader = trim( utf8_encode( quoted_printable_decode(imap_fetchbody($mbox, $msgNumber, 2.0))));
    // extract mailadress
    $mailAdress = substr(strstr(substr($mimeHeader, (strpos($mimeHeader, "Original-Recipient:")+27)), "\n", true),0,-1);
    echo $mailAdress." ";
   	// delete from db
   	if($mailAdress!= "" && $dbStatement->execute(array($mailAdress))){
   	
   	}else{
   		echo $dbStatement->queryString."<br />";
    	echo $dbStatement->errorInfo()[2];
   	}
   	// if affected a row? ->delete mail
    if(0<$dbStatement->rowCount()){
    	imap_delete($mbox,$msgNumber);
    	echo " -> found and deleted from DB...mail marked for deletion. ";
    	$mCounter++;
    }
    echo "<br>";
}
// finally delete the emails, end connection
imap_expunge($mbox);
imap_close($mbox);
$undeleted = $MC->Nmsgs - $mCounter;
echo "<br><br>Successful! deleted $mCounter adresses.<br>$undeleted couldn't get deleted.<br>";
?>
</body>
</html>
