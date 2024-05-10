<?php

$fg=file_get_contents('vcards.vcf');
$str=str_replace("=\r\n",'',$fg);
$m=explode('BEGIN:VCARD',$str);
$j=0;

$mas['nume']=array();

foreach($m as $v1)
{
	
$e=explode("\r\n",$v1);

$co=count($e)-1;

for($i=0; $i<=$co; $i++)
{
	
$v=trim($e[$i]);
if(strpos($v,'PRINTABLE:')!==false)
{
	
$ex1=explode(':',$v);
$ex1[1]=str_replace(';','',$ex1[1]);


$mas['nume'][$j]['name1']=quoted_printable_decode(trim($ex1[1]));
$i++;
$ex2=explode(':',$e[$i]);
$ex2[1]=str_replace(';','',$ex2[1]);

$mas['nume'][$j]['name2']=quoted_printable_decode(trim($ex2[1]));

}
	if(strpos($v,'TEL;')!==false)
{
	$dd='';
	for($s=1; $s<=3;$s++)
	{
if(strpos($e[$i],'TEL;')!==false)
{
	
$ex3=explode(':',$e[$i]);
$ex3[1]=str_replace(';','',$ex3[1]);
$dd.=trim($ex3[1]).(($s<=2) ? ';' : '');


}

$i++;
}
$mas['nume'][$j]['tel']=$dd;


}

}

$j++;
}
$file=file_get_contents('sample.html');
$tag='';
foreach($mas['nume'] as $k=>$v)
{
	$tag.='<tr><td>'.$v['name1'].'</td>';
$tag.='<td>'.$v['name2'].'</td>';
$tag.='<td>'.rtrim($v['tel'],';').'</td></tr>';
}
print str_replace('####htmlTAG####',$tag,$file);

?>