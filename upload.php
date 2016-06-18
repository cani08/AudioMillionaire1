<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="jquery.js"></script>  
    </head>
    <body>
        <?php
        session_start();
       ?>
        <a href='index.php'><button id='button-back' style="margin-bottom:30px;">Back to index page</button></a>
         <button id='btn-upload' >Upload a question</button>
         <button id='btn-edit'>Edit Questions</button>
        
    
        <div id='upload-question'>
        <center>Upload a question</center>
        <!--Upload form-->
        <div id="uploadfile">
            <form method="POST" enctype="multipart/form-data">
            <table border="0" cellpadding="1" cellspacing="1" class="box"> 
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <tr><td>Path of the audio file:</td><td>
                    <input type="text" value="questions/" name="path"/></td></tr>
                <p>Describe the question you just uploaded.</p>
                <tr>
                    <td>
                        Question:
                    </td>
                    <td>
                        
                        <textarea rows="4" cols="50" name="question"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Option1:
                    </td>
                    <td>
                        <textarea cols="50"  name="answer1"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Option2:
                    </td>
                    <td>
                        <textarea cols="50"  name="answer2"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Option3:
                    </td>
                    <td>
                        <textarea cols="50"  name="answer3"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Option4:
                    </td>
                    <td>
                        <textarea cols="50"  name="answer4"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Correct answer:
                    </td>
                    <td>
                        <input type="text" name="correct"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                       <input name="upload" style="float:right" type="submit"  id="upload" value=" Upload ">
                    </td>
                </tr>
            </table>
            </form>
        </div>
        </div>
        <div id='edit-questions'>
            
            <table>
                <tr><td style='width:40px;'></td><th style="width:500px;">Question</th><th></th></tr>
            <?php
            include 'connect.php';
        $displayQuestions=mysqli_query($conn,"SELECT * from questions")or die(mysqli_error($conn));
        while($row=mysqli_fetch_array($displayQuestions)){
            ?>
                <tr><td><?php echo $row['qid'];?></td><td><?php echo $row['description'];?></td><td>
                    <a href='upload.php?epr=delete&qid=<?php echo $row['qid'];?>'><img src='images/delete.png'></a></td></tr>
            <?php
        }   
            ?>
            </table>
        <?php
             //delete a question from database
         include 'connect.php';
        $epr='';
        if(isset($_GET['epr'])){
        $epr=$_GET['epr'];
        if($epr=='delete'){
            $id=$_GET['qid'];
            $delete=mysqli_query($conn,"DELETE FROM questions WHERE qid='$id'")or die(mysqli_error($conn));
            if($delete){
                echo "<b id='message'>Question removed Successfully!</b>";
            }else{
                echo "<b id='message'>Could not delete question</b>";
            }
        }}
            
            
            
            ?>
        
        
        </div>
         <script>
          $('#btn-upload').click(function() {
          $('#upload-question').show(200);
          $('#edit-questions').hide(200);
           });
         $('#btn-edit').click(function() {
          $('#upload-question').hide(200);
          $('#edit-questions').show(200);
           });
            
       function showDiv(divName){
           document.getElementById(divName).style.display='block';
       }
        function hideDiv(divName){
           document.getElementById(divName).style.display='none';
       }
        
        </script>
   <?php
        if(isset($_POST['upload'])){
            if(isset($_POST['path'])){
                $path=$_POST['path'];
            }
            if(isset($_POST['answer1'])){
                $answer1ph=$_POST['answer1'];
            }
            if(isset($_POST['answer2'])){
                $answer2ph=$_POST['answer2'];
            }
            if(isset($_POST['answer3'])){
                $answer3ph=$_POST['answer3'];
            }
            if(isset($_POST['answer4'])){
                $answer4ph=$_POST['answer4'];
            }
            if(isset($_POST['correct'])){
                $correct=$_POST['correct'];
            }
            
            if(!empty($_POST['question'])&& !empty($_POST['answer1'])
               &&!empty($_POST['answer2'])&&!empty($_POST['answer3'])
               &&!empty($_POST['answer4'])&&!empty($_POST['correct'])){
                $description=$_POST['question'];
                $answer1=$_POST['answer1'];
                $answer2=$_POST['answer2'];
                $answer3=$_POST['answer3'];
                $answer4=$_POST['answer4'];
                $correct=$_POST['correct'];
                $query=mysqli_query($conn,"INSERT into questions (description,correct,a,b,c,d,audiopath) 
                VALUES ('$description','$correct','$answer1','$answer2','$answer3','$answer4','$path')")or die(mysqli_error($conn));
                    if($query){
                        echo "<div id='message'>Question successfully uploaded to database.</div>";
                    }else{
                        echo "<div id='message'>Could not upload file!</div> ";
                    }

            }else{
                echo "<div id='message'>Please fill all the fields!</div>"; 
            }
        }
        
        
       
        
    ?><script>
        $("#message").delay(5000).fadeOut();
        </script>
    </body>
</html>