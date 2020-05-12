<?php

header('Content-Type: text/html; charset=gbk'); 


include 'py_convert.php';



$bags_of_week =1;


// $file = file_get_contents('./herb_02.txt', true);

$myChuFang = $_POST[ 'comment' ];

$bags_of_week =$_POST[ 'bags_of_week' ];

$patientName = $_POST[ 'usrname' ];

	
 
	echo "Patient Name:    ".$patientName;
 
	echo "<br><br>";
	
	echo "Rx:      ".wordwrap($myChuFang,35,"<br>\n");
 
	echo "<br>";


$validation = file_get_contents('setsymbol.txt', true);


 $my_chineseunit=substr($validation,0,2);   

 $my_delimiter =substr($validation,2,2);

// echo "my delimiter is:".$my_delimiter."||---------||"; ----------TEST OF start!

$unit ="GRAM"; //unit 

$newSeperate ="zzzz";

$file_new = str_replace($my_delimiter, $newSeperate, $myChuFang);  // --old  --new  --string


// $file_new = str_replace($my_chineseunit, $newSeperate, $file_new);

// echo "HanZiZhuanHuanPinYin".iconv('utf-8', 'gbk',"汉字转拼音")."HanZiZhuanHuanPinYin";

// $file_new=iconv('gb2312', 'gbk',$file_new);   // --out, --in, --string  VERY VERY VERY IMPORTANT!!!! 

// echo "******2222****>>>".$file_new."<<<*******2222********";

$str_arr = explode ("zzzz", $file_new); 



function my_offset($text){
    preg_match('/^\D*(?=\d)/', $text, $m);   
	return isset($m[0]) ? strlen($m[0]) : false;
	
}



$pin = new pin();

$www_output=[];

$total = 0.0;


for ($i = 0; $i < count($str_arr); $i++) {
	
	$position=my_offset($str_arr[$i]);
	
	$str_herb=substr($str_arr[$i], 0,($position-strlen($str_arr[$i])));     // Algorithm: Trim out the rest of EACH UNIT od ArrayS
	

	$str_number =preg_replace('/[^0-9\.]/', '', $str_arr[$i]);
	
	
	$get_pinyin = $pin->Pinyin($str_herb,'gb2312');	//-----in 'gb2312'-----------
	
	$get_pinyin = iconv('gbk', 'gb2312',$get_pinyin); // --out, --in, --string
	

	$result= $get_pinyin."zzzz".$str_herb."zzzz".$str_number."\r\n";

	$result = trim(preg_replace('/\s+/', ' ', $result));
	
	$array_herb = explode("zzzz", $result);
	
	
	$stack[]= $array_herb;  //  ----IMPORTANT
	
	$total += array_sum($stack[$i]); // ------------Total amount in Grams (克）
	
}   //-----------------------------------------------end of loop please do not delete, easily to be ignored.



	$keys = array_column($stack, 0 );

	array_multisort($keys, SORT_ASC, $stack);
	
	
	$numberOfHerbs = count($stack); //  -------------Total Number of Herbs used in Prescreption 
	
	$averageAmount = $total/$bags_of_week;
	
	$averageAmount = number_format($averageAmount, 2, '.', ''); 

//	print_r($stack);
	

//	var_dump($stack);


// print_r($sort_arr);

/*

$myfile = fopen("frame.txt", "w") or die("Unable to open file!");

fwrite($myfile, $www_output);

fclose($myfile);

*/

echo "<!DOCTYPE html>";
echo "<head>";
echo "<title>CareCure_Home</title>";
echo '<meta name = "viewport" content = "user-scalable=no, width=device-width">';	

echo "<br><br>";
echo "</head>";
echo "<table>";

   foreach ($stack as $column) {
	   
	echo "<tr>";
      echo "<td>$column[0]</td>";
	  echo '<td>&emsp;</td>';
	  echo "<td>$column[1]</td>";
	  echo '<td>&emsp;</td>';
	  echo "<td>$column[2]</td>";
	  echo '<td>&emsp;</td>';
	  echo "<td>$my_chineseunit(g)</td>";  
	echo "</tr>";
}
   


//   echo $total;
//	 echo "*****************";
//	 echo $numberOfHerbs ;

//	 echo "<tr>";
//		echo "<td></td>";
//		echo "<td>&emsp;</td>";
//		echo "<td></td>";
//		echo "<td>&emsp;</td>";
//		echo "<td></td>";
//		echo "<td>&emsp;</td>";
//		echo "<td></td>";
//	echo "</tr>";
	
	 echo "<tr>";
		echo "<td>--------------</td>";
		echo "<td>&emsp;</td>";
		echo "<td>--------------</td>";
		echo "<td>&emsp;</td>";
		echo "<td>--------------</td>";
		echo "<td>&emsp;</td>";
		echo "<td>--------------</td>";
	echo "</tr>";
	

   
    echo "<tr>";
		echo "<td>Total:</td>";
		echo "<td>&emsp;</td>";
		echo "<td>$numberOfHerbs</td>";
		echo "<td>&emsp;</td>";
		echo "<td>$total</td>";
		echo "<td>&emsp;</td>";
		echo "<td>$averageAmount&nbsp;&nbsp;($bags_of_week)</td>";
	echo "</tr>";
	
echo "</table>";

echo "</html>";



