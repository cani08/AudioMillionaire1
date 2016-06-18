<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="jquery.js"></script> 
    </head>
    <body>
        <div id='wrapper'>
        <?php
        
       
       // echo "<a href='upload.php'>Upload e new file</a>";
           
        echo "<button id='login-btn' onclick=''>Login</button>";
          
        ?>
      
        <div id='login-form'>
                                                <!--X- button -->
          <img id='xbutton' onclick ="hideDiv('login-form')" src="images/close.png" height="40px" style="float:right; margin-right:30px; margin-top:0px;">
            
            <label id="login-description">Login as admin to insert or edit questions</label>
            <div id='login-tbl'>
            <form method="POST" action="index.php">
              <table>
                  <tr>
                      <td>Username:</td><td><input type="text" name="username"/></td>
                  </tr>
                  <tr>
                      <td>Password:</td><td><input type="password" name="password"/></td>
                  </tr>
                   <tr>
                      <td></td><td><input id= 'login-btn1' style='float:right;' type="submit" name="submit" value="login"/></td>
                  </tr>
              </table>
            </form>
            </div>
        </div>
        <?php 
        include 'connect.php';
            
     
                                                        //login
        if(isset($_POST['submit'])){
            if(isset($_POST['username'])&&isset($_POST['password'])){
                if(!empty($_POST['username'])&& !empty($_POST['password'])){
                $username=$_POST['username'];
                $password=md5($_POST['password']);
                
                
                $loginquery=mysqli_query($conn,"SELECT * from users where username='$username' and password='$password'")or die(mysqli_error($conn));
                $checkadmin=mysqli_query($conn,"SELECT * from users where username='$username'") or die(mysqli_error($conn));    
                if(mysqli_num_rows($loginquery)==1){
                    while($row=mysqli_fetch_array($checkadmin)){
                        if ($row['isadmin']=='true'){
                              header("Location:upload.php");
                              session_start();
                              $_SESSION['login_admin']='admin';
                        }else{
                            echo "The user is not an administrator!";
                            $_SESSION['login_user']=$username;
                        }
                    }
                  
                }else{
                    echo "Wrong username or password";
                }    
                    
                }else{
                    echo "Please fill both fields!";
                }
            }
        }
       

        ?>
          <script>
        $('#login-btn').click(function() {
          $('#login-form').fadeIn(500);
           });
       $(document).keyup(function(e) {
          if (e.keyCode == KEYCODE_ESC) {
              document.getElementById('login-form').style.display='none'
          }
        });
            
        function hideDiv(divID){
            document.getElementById(divID).style.display='none'
        }  

        </script>
        
        </div>
        
        <h2 id="test_status"></h2>
        <div id='quiz'>
            
            
        
        <script>
             
            
            var pos = 0, test, test_status, question, choice, choices, chA, chB, chC, correct = 0,audio, audioCorrect,path,choice1,testvar, pressedkey;
            var questions = [
                [ "Cili eshte sistemi operativ i iPhone?", "iOS", "Windows", "Linux", "Android","questions/iphone.wav","a" ],
                [ "Si quhet stili i te kenduarit pa instrumente?", "Kendim koral", "Instrumental", "A Cappella", "Kuartet","questions/kendim.wav","c" ],
                [ "Cili eshte shenuesi me i mire ne basketboll ne karieren e NBA-s?", "Magic Johnson", "Karl Malone", "Kareem Abdul Jabbar", "Kobe Bryant","questions/nba.wav","c" ],
                [ "Kush eshte presidenti i pare i SHBA?", "George Washington", "John Kennedy", "Bill Clinton", "George W.Bush","questions/presidenti.wav","a" ],
                [ "Question5", "Option1", "Option2", "Option3", "Option4","questions/soport.wav","a" ],
                [ "Question6", "Option1", "Option2", "Option3", "Option4","questions/stadium.wav","a" ],
                [ "Question7", "Option1", "Option2", "Option3", "Option4","questions/uji.wav","c" ],
                [ "Question8", "Option1", "Option2", "Option3", "Option4","questions/win7.wav","a" ],
                [ "Question9", "Option1", "Option2", "Option3", "Option4","questions/rrugakombit.wav","b" ],
                [ "Question10", "Option1", "Option2", "Option3", "Option4","questions/rruga.wav","d" ]   
            ];
            function _(x){
                return document.getElementById(x);
            }
            
            
                                ///rendering of the question
            function renderQuestion(){
                
                                    /////playing of the question audio
                audio = new Audio();
                audio.src = questions[pos][5];
                audio.loop = false;
                audio.play();
                test = _("quiz");
                if(pos >= questions.length){
                    test.innerHTML = "<h2>You got "+correct+" of "+questions.length+" questions correct</h2>";
                    _("test_status").innerHTML = "Test Completed";
                    pos = 0;
                    correct = 0;
                    return false;
	        }
                   _("test_status").innerHTML = "Question "+(pos+1)+" of "+questions.length;
                    question = questions[pos][0];
                    chA = questions[pos][1];
                    chB = questions[pos][2];
                    chC = questions[pos][3];
                    chD = questions[pos][4];
                    test.innerHTML = "<h3>"+question+"</h3>";
                    test.innerHTML += "A: <input type='radio' name='choices' value='A'> "+chA+"<br><br/>";
                    test.innerHTML += "B: <input type='radio' name='choices' value='B'> "+chB+"<br><br/>";
                    test.innerHTML += "C: <input type='radio' name='choices' value='C'> "+chC+"<br><br/>";
                    test.innerHTML += "D: <input type='radio' name='choices' value='D'> "+chD+"<br><br>";
                    
                    test.innerHTML +=  "<input type='text' size='50' onkeydown='keyCode(event)' autofocus>";
                    test.innerHTML+="<button id='repeat' onclick='renderQuestion();'>play again</button>";
            }
            
            ////playing of the confirmation audio
             function sound1(path){
                                    var audio = document.createElement("audio");
                                    audio.src = path;
                                    audio.addEventListener("ended", function () {
                                        document.removeChild(this);
                                    }, false);
                                    audio.play();   
                            }
            
            
            ///user inputs the values(the answer they respond with)
            
            
                     function keyCode(event) {
                        var x = event.keyCode;
                        if(x==65 || x==66 || x==67 ||x==68 || x==32){
                            if (x == 65) {
                                //sound1("questions/asa.wav");
                               // pressedkey=prompt("Are you sure your answer is A!");
                                //if(pressedkey== "a"){
                                    audio.pause();
                                    checkAnswer("a");
                                //}
                                
                            }else if(x==66){
                               // sound1("questions/asb.wav");
                                    audio.pause();
                                    checkAnswer("b");
                                
                            }
                             else if(x==67){
                                // sound1("questions/asc.wav");
                                // pressedkey=prompt("Are you sure your answer is A!");
                               // if(pressedkey=="c"){
                                 audio.pause();
                                    checkAnswer("c");
                               // } 
                                
                            }
                             else if(x==68){
                                 //sound1("questions/asd.wav");
                                // pressedkey=prompt("Are you sure your answer is A!");
                                 //if(pressedkey=="d"){
                                     audio.pause();
                                     checkAnswer("d");
                            //     }
                                  
                            }
                            else if(x==32){
                                 //sound1("questions/asd.wav");
                                // pressedkey=prompt("Are you sure your answer is A!");
                                 //if(pressedkey=="d"){
                                audio.pause();
                                 document.getElementById("repeat").click();
                                  
                            }
                        }
                     }
            
                            ///////Check Answer
            
            
                        function checkAnswer(testvar){
                            function sound(path){
                                    var audio = document.createElement("audio");
                                    audio.src = path;
                                    audio.addEventListener("ended", function () {
                                        document.removeChild(this);
                                    }, false);
                                    audio.play();   
                            }
                            
                            ///correct answer
                            
                            if(testvar == questions[pos][6]){
                                audio.pause();
                                sound("questions/sakte.wav");
                                correct++;
                                pos++;
                                setTimeout(function() {
                                     renderQuestion();
                                }, 2000);
                            }else{
                                
                                ///wrong answer
                                
                                if(questions[pos][6]=="a"){
                                    audio.pause();
                                    sound("questions/a.wav");}
                                else if(questions[pos][6]=="b"){
                                    audio.pause();
                                    sound("questions/b.wav");}
                                 else if(questions[pos][6]=="c"){
                                     audio.pause();
                                    sound("questions/c.wav");}
                                 else if(questions[pos][6]=="d"){
                                     audio.pause();
                                    sound("questions/d.wav");}
                                  test.innerHTML = "Sorry, wrong answer, your total points: "+pos;
                            }

                     }
            
    window.addEventListener("load", renderQuestion, false);
            
         
        /*  $.getJSON('test2.php',function(data){
                  console.log(data);
                    
                    
           });  
         document.write(myjson);*/
            
            
                                        //get the data from JSON file
       
     
        </script>
           
        </div>

    </body>
</html>