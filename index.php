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

                                             //marrja e te gjitha IDve te pyetjeve ne databaze
       /* $questions =array();
        $selectIds=mysqli_query($conn,'select qid from questions')or die (mysqli_error($conn));

        while($row=mysqli_fetch_array($selectIds)){
            $questions[]=$row['qid'];
        }
            for($k=0;$k<count($questions);$k++){
            echo " ".$questions[$k];
            }
        $lastID=$questions[count($questions)-1];
        $firstId=$questions[0];
        $randomQuestions=array();
            echo "<br/>";


                                                    //perzgjedhja e random questions
        for($i=0;$i<5;$i++){
            $randomNumber=rand($firstId,$lastID);
            if(in_array($randomNumber,$questions)&& !in_array($randomNumber,$randomQuestions)){
               $randomQuestions[$i]=$randomNumber;
            }else{
                $i--;
            }
        }

                                                        //printimi i random questions
        for($t=0;$t<count($randomQuestions);$t++){
            echo " ".$randomQuestions[$t];
            }*/


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
              
            questions = [ ];
                    $.getJSON('http://localhost:8080/audioMillionaire/test2.php', function(result){
                        $.each(result, function() {
                            questions.push([this.description,this.a,this.b,this.c,this.d,this.audiopath,this.correct ] );
                        });
                   });
             
           
              
        
             
                      //alert(questionJSONS[0][0]);
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
            <!--<div id='question'></div> <br/>
            <div id='OptionA'></div>    <br/>
            <div id='OptionB'></div>    <br/>
            <div id='OptionC'></div>    <br/>
            <div id='OptionD'></div>    <br/>-->


        <script>

             var pos = 0, test, test_status, question, choice, choices, chA, chB, chC, correct = 0,audio, audioCorrect,path,choice1,testvar, pressedkey;

            

           /* var questiont = [
                [ "Cili eshte sistemi operativ i iPhone?", "iOS", "Windows", "Linux", "Android","questions/iphone.wav","a" ],
                [ "Si quhet stili i te kenduarit pa instrumente?", "Kendim koral", "Instrumental", "A Cappella", "Kuartet","questions/kendim.wav","c" ],
                [ "Cili eshte shenuesi me i mire ne basketboll ne karieren e NBA-s?", "Magic Johnson", "Karl Malone", "Kareem Abdul Jabbar", "Kobe Bryant","questions/nba.wav","c" ],
                [ "Kush eshte presidenti i pare i SHBA?", "George Washington", "John Kennedy", "Bill Clinton", "George W.Bush","questions/presidenti.wav","a" ],
                [ "Question5", "Option1", "Option2", "Option3", "Option4","questions/sport.wav","a" ],
                [ "Question6", "Option1", "Option2", "Option3", "Option4","questions/stadium.wav","a" ],
                [ "Question7", "Option1", "Option2", "Option3", "Option4","questions/uji.wav","c" ],
                [ "Question8", "Option1", "Option2", "Option3", "Option4","questions/win7.wav","a" ],
                [ "Question9", "Option1", "Option2", "Option3", "Option4","questions/rrugakombit.wav","b" ],
                [ "Question10", "Option1", "Option2", "Option3", "Option4","questions/rruga.wav","d" ]
            ];*/
            
            console.log(questions);
                    function _(x){
                        return document.getElementById(x);
                    }

                    function startQuiz(){
              if(pos==0){
                   // sound1.pause();
                    sound1("questions/info.wav");
                    setTimeout(function() {
                        renderQuestion();
                                },8000);
                }
            }

                                ///rendering of the question
                    function renderQuestion(){
                 
                test = _("quiz");
                        if(pos >= questions.length){
                            test.innerHTML = "<h2>You Won!</h2>";
                            _("test_status").innerHTML = "Test Completed";
                            pos = 0;
                            correct = 0;
                            test.innerHTML="<button id='restartGame' onclick='renderQuestion();'>Rifillo lojen!</button>";
                            return false;
                        }
                                               /////playing of the question audio
                    audio = new Audio();
                    audio.src = questions[pos][5];
                    audio.loop = false;
                    audio.play();
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
                    test.innerHTML +=  "<input id='q"+pos+"' type='text' size='50' onkeydown='keyCode(event)' autofocus onfocus='sound1('questions/asa.wav');'>";

                    test.innerHTML+="<button id='repeat' onclick='renderQuestion();'>Replay Question</button>";
                $( "#q"+pos ).focus();
            }

            ////playing of the confirmation audio
                    function sound1(path){
                    var audio = document.createElement("audio");
                    audio.src = path;
                    audio.addEventListener("ended", function () {
                        document.removeChild(this);}, false);
                    audio.play();
            }

            ///user inputs the values(the answer they respond with)

                    function confirma(event){
                        var y=event.keyCode;
                        if(y==65|| y==13){
                            checkAnswer("a");
                        }else if(y==27){
                            sound1("questions/back.wav");
                            audio.pause();
                            renderQuestion();
                            audio.pause();
                        }
                    }

                    function confirmb(event){
                        var y=event.keyCode;
                        if(y==66|| y==13){
                            checkAnswer("b");
                        }else if(y==27){
                             sound1("questions/back.wav");
                            audio.pause();
                            renderQuestion();
                            audio.pause();
                        }
                    }

                    function confirmc(event){
                        var y=event.keyCode;
                        if(y==67 || y==13){
                            checkAnswer("c");
                        }
                        else if(y==27){
                             sound1("questions/back.wav");
                             audio.pause();
                             renderQuestion();
                             audio.pause();
                        }
                    }

                    function confirmd(event){
                        var y=event.keyCode;
                        if(y==68|| y==13){
                            checkAnswer("d");
                        }
                        else if(y==27){
                             sound1("questions/back.wav");
                            audio.pause();
                             renderQuestion();
                            audio.pause();
                        }
                    }
            
                    function keyCode(event) {
                        var x = event.keyCode;
                        if(x==65 || x==66 || x==67 ||x==68 || x==32){
                            if (x == 65) {
                                    audio.pause();
                                    sound1("questions/asa.wav");
                                    test.innerHTML +=  "<input id='q1"+pos+"' type='text' size='50' onkeydown='confirma(event)' autofocus>";
                                    $("#q1"+pos ).focus();
                            }else if(x==66){
                                    audio.pause();
                                    sound1("questions/asb.wav");
                                    test.innerHTML +=  "<input id='q1"+pos+"' type='text' size='50' onkeydown='confirmb(event)' autofocus>";
                                    $("#q1"+pos ).focus();
                            }
                             else if(x==67){
                                    audio.pause();
                                    sound1("questions/asc.wav");
                                    test.innerHTML +=  "<input id='q1"+pos+"' type='text' size='50' onkeydown='confirmc(event)' autofocus>";
                                    $("#q1"+pos ).focus();
                            }
                             else if(x==68){
                                    audio.pause();
                                    sound1("questions/asd.wav");
                                    test.innerHTML +=  "<input id='q1"+pos+"' type='text' size='50' onkeydown='confirmd(event)' autofocus>";
                                    $("#q1"+pos ).focus();
                            }
                            else if(x==32){
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
                                pos=0
                                 test.innerHTML+= "<input id='restart' type='text' onkeydown='restart(event)'/>";
                                 test.innerHTML+="<button id='restartGame'onclick='renderQuestion();'>Rifillo lojen!</button>";
                                 $("#restart").focus();
                            }

                     }
            
          
            //restart event 
            function restart(event){
                       // sound1("questions/info.wav");
                        var y=event.keyCode;
                        if(y==32){
                            startQuiz();
                        }
            }
        </script>
            
            <button id='startQuiz' onclick='startQuiz();' onkeydown='restart(event);' onmouseover="sound1('questions/starto.wav')">Start Quiz</button>
        </div>

    </body>
</html>
