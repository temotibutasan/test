<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>PHP開発用デバッグメニュー</title>
</head>
<body>
PHP開発用　PHPファイルリンク一覧<br>


<?php
// ディレクトリのパスを記述
$dir = "xxxxxxxx" ;
// 既知のディレクトリをオープンし、その内容を読み込みます。
if (is_dir($dir)) {

    // [ul]タグ
    echo "<ul>" ;
    //ファイル一覧を取得
    $array = array();
    GetDirFileList($array,$dir);
    //print_r($array); 
    foreach ($array as $value) {
            $kind = filetype($value);
	    if( $kind == "file" ) {
                if(preg_match("(php|html)",$value)) {
                  $link=str_replace($dir."\\","",$value);
		  $link=str_replace("\\","/",$link);
		  if($tilte=GetLocalTitle($value) !== "")
                  echo "<a href=\"".$link."\">[file]:".GetLocalTitle($value)."(".$value.")</a></br>\n";
                }
	    }
    }

    // [ul]タグ
    echo "</ul>" ;
}
//-------------------------------------------------
// htmlタイトル取得
//--------------------------------------------------
function GetLocalTitle($file){
	$html = file_get_contents($file);
	preg_match('/<title>(.+)<\/title>/',$html,$matches);
	if(isset($matches[1])==false) return "";

	$title = $matches[1];
	return $title;
}

//-------------------------------------------------
// 検索開始
//--------------------------------------------------
function GetDirFileList(&$array,$dir)
{
    $sepa = DIRECTORY_SEPARATOR;

    if (!is_dir($dir)) return false;

    if (!$dp= opendir($dir)) {
        die("開けません");
    }

    //指定のディレクトリ内検索
    while (($file=readdir($dp)) !== false) {	// falseが返らない間ループ
        if ($file === '.' || $file === '..') continue;	// スキップ

        if (is_dir("$dir$sepa$file")) {	// ディレクトリなら再帰処理
	    GetDirFileList($array,"$dir$sepa$file");
        }
        else if(is_file("$dir$sepa$file")){
            // ファイルのみ取得
            //echo "$dir$sepa$file<br>";
            $array[count($array)] = "$dir$sepa$file";
        }
    }
    closedir($dp);
}
?>



</body>
</html>
