# mailsolved delete Delivery failures

This is supposed to work with https://usolved.net/scripts/mailsolved

You know the problem, many people don't care that much about their mailboxes, change their adress and when you send your newsletter, you get a ton of Mail Delivery Failures. 

One option is to delete them all by hand.
Second option is to use this script: 
 
  1. enter your mail server, pw , username
  2. enter your connection to the database
  3. enter your db prefix on $dbTable. All subscpriptions are in the table _entries.
  4. run the script and get a simple output that tells you everything you need to know. 
  
  - The Script searches the MIME 2.0 header
  - puts it on the screen
  - searches for the email in the db and deletes it.
  - if successfull it deletes the mail, too. 
  
  simply as that!
  
