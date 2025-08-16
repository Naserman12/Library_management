<?php
$count = 0;
for($i = 0; $i < 101; $i++ ){

    if($i%3  == 0 && $i%5 == 0):
      echo  $i. " is FizzBuzz<br>";
    else: if ($i%3 == 0):
          echo $i. ' is Fizz<br>';
        elseif ($i%5 ==0):
            echo $i. ' is Buzz<br>';
        else:
            echo $i ."<br>";
        endif;
        endif;
}
