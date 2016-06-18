<?php

header('Content-type:application/json');
include 'connect.php';
    $questions =array();
        $selectIds=mysqli_query($conn,'select qid from questions')or die (mysqli_error($conn));
            
        while($row=mysqli_fetch_array($selectIds)){
            $questions[]=$row['qid'];
        }
            
        $lastID=$questions[count($questions)-1];
        $firstId=$questions[0];
        $randomQuestions=array();


          
                                        //perzgjedhja e random questions
        for($i=0;$i<10;$i++){
            $randomNumber=rand($firstId,$lastID);
            if(in_array($randomNumber,$questions)&& !in_array($randomNumber,$randomQuestions)){
               $randomQuestions[$i]=$randomNumber;
            }else{
                $i--;
            }
        }


        $results=array();
        for($l=0;$l<count($randomQuestions);$l++){
        $temp=$randomQuestions[$l];
        $sth = mysqli_query($conn,"SELECT qid,description,audiopath,a,b,c,d,correct from questions where qid='$temp'") or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($sth)) {
                $results[]=$row;
        }
    }
         echo json_encode($results);





