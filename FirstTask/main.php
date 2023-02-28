<?php
  class Validator {
    function validate($cardNumber) { 
      $mastercard_pattern = '/^5[1-5][0-9]{14}$|^62[0-9]{14}$|^67[0-9]{14}$/';
      $visa_pattern = '/^4[1-9][0-9]{14}$|^14[0-9]{14}$/';

      $cardNumber = preg_replace('/\D/', '', $cardNumber);
      
      $sum = 0;
      for ($i = 1; $i <= strlen($cardNumber); $i++) {
        $num = substr($cardNumber, -$i, 1);
        if ($i % 2 == 0) {
          $doubleNum = $num * 2;

          if ($doubleNum < 10) {
            $sum += $doubleNum;
          } else {
            $sum += $doubleNum - 9;
          }
        } else {
          $sum += $num;
        }
}
     
       $result = false;
       if (($sum % 10) == 0) {
        $result = true;
       }

       $output = 'Невалидная/Неизвестный эмитент';
       if(preg_match($mastercard_pattern, $cardNumber) && $result === true) {
        $output = 'Валидная/MasterCard';
       }

       if(preg_match($visa_pattern, $cardNumber) && $result === true) {
        $output = 'Валидная/Visa';
       }

       if(!preg_match($visa_pattern, $cardNumber) && !preg_match($mastercard_pattern, $cardNumber) && $result === true) {
        $output = 'Валидная/Неизвестный эмитент';
       }

       return $output;
    }
  }

    $cardNumber = fgets(STDIN);
    $validator = new Validator()
    $result = validator.validate($cardNumber);
    echo $result;
?>