<?
class main {
  function auth() {
     global $cnf;
     if (!isset($_SESSION['admin'])) {
         $pass=$_POST['pass'];
             if (isset($pass) && empty($pass)) {
                  die("������: ����� ��������� ��� ����");
             }

             if (isset($pass) && !empty($pass)) {

                  if ($pass==$cnf['pass']) {
                       $_SESSION['admin']=$cnf['pass'];
                        print "<html><head><META HTTP-EQUIV='Refresh' content ='0;'></head></html>";
                  }
                  else {
                      die("������: �������� ����� ��� ������!");
                  }
           }
             print "
         <html>
         <head>
         <title>�����������</title>
         <LINK REL=\"StyleSheet\" HREF=\"style.css\" TYPE=\"text/css\">
         </head>
         <body>
         <form method=POST >
         <table width=\"98%\" border=\"0\" bordercolor=\"white\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
         <tr>
         <td valign=top width=5%></td>
         <td valign=top>
            <table border=\"0\" bordercolor=\"white\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=30%>
            <tr bgcolor=\"#016FAE\">
            <td style=\"BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid;\">
            <div style=\"margin-left:2;\"><font face=\"tahoma\" size=\"1\"><b>
            �����������:
            </b>
            </td>
            </tr>
            <tr bgcolor=\"FFFFFF\">
            <td style=\"BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 0px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid;\">
            <div style=\"margin-left:2;margin-top:2;margin-bottom:2;margin-right:2;\"><font face=\"verdana\" size=\"1\">
              <table cellpadding=\"0\" cellspacing=\"0\" width=100%>
              <tr>
              <td><font face=\"verdana\" size=\"1\"><b>������� ������: </b></font></td><td><input type=password name='pass'></td>
              </table> <br>
            <center><input type=submit value='�������' class='button' ></center>
            </td>
            </tr>
            </table>
         </td>
         </tr>
         </table>
         </form>
         </body>
         </html>";
          exit;

         }
 }
  function upload() {
        global $cnf;
      $dir = $_POST['DIR'];
      $file = $_FILES["FILE"]["tmp_name"];
      if (empty($_GET['DIR'])) {
          $DIR=$cnf['path'];
      }
      else {
          $DIR=$_GET['DIR'];
      }
        print "<center><b>�������� �����</b></center><br>";
        if (isset($dir) && empty($dir) || isset($file) && empty($file)) {
            $this->ok('������: ��� ���� ����� ���������');
            exit;
        }
       if (isset($dir) && !empty($dir) && !is_dir($dir))  {
            $this->ok('������: ���������� �� ����������');
            exit;
        }
       if (isset($dir) && !empty($dir) && !is_writable($dir)){
            $this->ok('������: ����������� ����� ������� � ����������');
            exit;
        }
        if (isset($dir) && !empty($dir) || isset($file) && !empty($file)) {
              $file_name = $_FILES["FILE"]["name"];
              $dir=trim($dir);
               if (@move_uploaded_file($file, "$dir/$file_name")) {
                    chmod("$dir/$file_name",0755);
                    $link=preg_replace("#(.*)$chf[path]\/(.+)#i","\\2",$dir);

                    $link="http://".$_SERVER['HTTP_HOST']."/".$link."/".$file_name;
                    $this->ok("����: $file_name ������� ��������,������: $link");
                    exit;

             }
               else {
                    $this->ok("������: ���������� ��������� ����: $file_name");
                     exit;
             }
     }
       print "
          <form method=POST enctype=\"multipart/form-data\" >
          <table width=100%>
          <tr>
          <td>
            <table width=100%>
            <tr>
            <td width=25%><b>���������� ��������:</b></td><td> <input type=text name='DIR' value=$DIR size=37> </td>
            <tr>
            <td width=25%> <b>����:</b></td><td> <input type=file name='FILE' size=40></td>
            </tr>
            </table>
          </tr>
          <tr>
          <td align=center>
          <input type=submit value='���������' class=button >
          </td>
          </table>
          </form>";
   }
    function ok($ok) {

           print "
           <table width=50% align=center style='border:1px solid #000000'>
           <tr>
           <td align=center><b>$ok<b><br><a href='index.php' >[�� �������]</a></td>
           </tr>
           </table>";

   }
     function mfile() {
        global $cnf;
        $DIR=$_GET['DIR'];
        $dir=$_POST['dir'];
        $file_name=$_POST['file_name'];
        $ftext=$_POST['ftext'];
        print "<center><b>�������� �����</b></center><br>";
        if (empty($DIR)) {
            $DIR=$cnf['path'];
        }
        if (isset ($dir) && $dir=='' || isset ($file_name) && $file_name=='' ) {
            $this->ok('������: ����� ��������� ����: "����������" � "�������� �����"');
            exit;
        }
        if (isset ($file_name) && preg_match("#[\/\:\*\?\"<>\|]#", $file_name)) {
            $this->ok('������: ��� �� ������ ��������� / \ : * ? \" <> | ');
            exit;
        }
        if (isset ($dir) && !is_dir($dir))  {
            $this->ok('������: ���������� �� ����������');
            exit;
        }
        if (isset ($dir) && !is_writable($dir)){
            $this->ok('������: ����������� ����� ������� � ����������');
            exit;
        }
        if (isset ($dir) && isset ($file_name) && file_exists("$dir/$file_name") && $dir!=='' && $file_name!=='') {
            $this->ok('������: ����� ���� ��� ����������');
            exit;
        }
        if (isset ($dir) && $dir!=='' || isset ($file_name) && $file_name!=='' ) {
        $asp=preg_replace("#(.*)\.#","",$file_name);
        $asp=strtolower($asp);
        $fp=@file_get_contents('type.dat');
        $fp=explode('|',$fp);
         if (!in_array($asp,$fp)) {
               $this->ok('������: ��� ����� �� ��������������');
               exit;
             }

           $op = fopen ("$dir/$file_name", "w");
					fputs ($op,$ftext);
					fclose ($op);
               $this->ok("����: $dir/$file_name ������� ������");
               exit;
        }
        print "
          <form method=POST>
          <table width=100%>
          <tr>
          <td>
            <table width=100%>
            <tr>
            <td width=20%><b>����������:</td><td><input type=text name='dir' value=$DIR size=40 > </td>
            <tr>
            <td width=20%><b>�������� �����:</td><td> <input type=text name='file_name' size=40> </td>
            </table>
          </td>
          </tr>
          <tr>
          <td align=center ><b>���������� �����:<br> <textarea cols=50 rows=10 name=ftext ></textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='�������' class=button >
          </td>
          </table>
          </form> ";
    }
 function rall($r) {
      global $cnf,$do;
            print "<center><b>��������</b></center><br>";
            
           if (!file_exists($r)){
               $this->ok("������: ����: $r �� ������");
                exit;
           }
           if (!is_writable($r)) {
               $this->ok("������: ����������� ����� ������� � ����������");
                exit;
           }
           $asp=preg_replace("#(.*)\.#","",$r);
           $asp=strtolower($asp);
           $fp=@file_get_contents('type.dat');
           $fp=explode('|',$fp);
           if (!in_array($asp,$fp)) {
               $this->ok('������: ��� ����� �� ��������������');
               exit;
             }

           $ftext=$_POST['ftext'];
              if (isset($ftext)) {
                     $ftext=stripslashes($ftext);
                     $fp=fopen($r,"w");
                         fputs($fp,$ftext);
                         fclose($fp);
                         $this->ok("���� ������� ������");
                         exit;
                   }
           $fp=fopen($r,"r");
           $frtext = fread($fp, filesize($r));
                     fclose($fp);
           $frtext=htmlspecialchars($frtext);
           $frtext=stripslashes($frtext);
           print "
          <form method=POST>
          <table width=100%>
          <tr>
          <td align=center ><b>���������� �����:<br> <textarea cols=55 rows=10 name=ftext >$frtext</textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='�������' class=button >
          </td>
          </table>
          </form> ";

   }
   function rname($rname) {
     global $cnf,$do;
        if (!file_exists($rname) && !is_dir($rname))  {
             $this->ok("������: ����/����������: $rname �� ������");
             exit;
        }
        $dir=preg_replace("#\/([^\/]+)$#","",$rname);
        $nname=trim($_POST['nname']);
           if (isset($nname) && !empty($nname)) {
                if (!is_writable($rname) && !is_writable($dir)) {
                    $this->ok("������: ����������� ����� ������� � �����/����������");
                     exit;
                 }
                 if (preg_match("#[\/\:\*\?\"<>\|]#", $nname)) {
                    $this->ok('������: ��� �� ������ ��������� / \ : * ? \" <> | ');
                    exit;
                 }
                 rename($rname, "$dir/$nname");
                    $this->ok('��� �����/���������� ������� ��������');
                    exit;
              }
        $name=preg_replace("#(.*)\/#","",$rname);
        print "<form method=POST >������� ����� ��� �����/����������: <input type=text name=nname value=\"$name\"><input type=submit value=��������� ></form>";
 }
 
 function makedir($mkdir) {
     global $cnf,$do;
       $name=$_POST['nname'];
       if (!is_dir($mkdir)) {
           $this->ok("������: ���������� $mkdir �� �������");
           exit;
       }
       if (!is_writable($mkdir)) {
           $this->ok("������: ����������� ����� ������� � ����������");
           exit;
       }
         if (isset($name) && !empty($name)) {
         if (preg_match("#[\/\:\*\?\"<>\|]#", $name)) {
              $this->ok('������: ��� �� ������ ��������� / \ : * ? \" <> | ');
              exit;
              }
         if (is_dir("$mkdir/$name")){
              $this->ok('������: ����� ���������� ��� ����������');
              exit;
            }
              mkdir("$mkdir/".trim($name)."");
              $this->ok("����������: $mkdir/$name ������� �������");
              exit;
         }
      print "<form method=POST >������� ��� ����������: <input type=text name=nname ><input type=submit value=������� ></form>";
 }
  function fcopy($fcopy,$sost=false) {
     global $cnf,$do;
       $dir=$_POST['dir'];
       if (!file_exists($fcopy)) {
           $this->ok("������: ���� $fcopy �� �������");
           exit;
       }
       if (!is_writable($fcopy)) {
           $this->ok("������: ����������� ����� ������� � ����������");
           exit;
       }
         if (isset($dir) && !empty($dir)) {
         $file_name=preg_replace("#(.+)\/([^\/]+)$#","\\2",$fcopy);
         if (file_exists("$dir/$file_name")){
              $this->ok('������: ������ ���� ��� ����������');
              exit;
            }
         if (!is_dir("$dir")){
              $this->ok('������: ���������� ����������� �� ����������');
              exit;
            }
              copy($fcopy,"$dir/$file_name");
              if ($sost) {
              unlink($fcopy);
              $this->ok("���� $file_name ������� ���������");
               }
               else {
              $this->ok("���� $file_name ������� ���������");
               }
              chmod("$dir/$file_name",0755);

              exit;
         }
      print "<form method=POST >���� �����������/����������: <input type=text name=dir ><input type=submit value=OK ></form>";
 }
  function deldir($del) {
     global $cnf,$do;
       if (!file_exists($del) && !is_dir($del))  {
             $this->ok("������: ����/����������: $del �� ������");
             exit;
        }
      if (!is_writable($del)) {
           $this->ok("������: ����������� ����� ������� � �����/����������");
           exit;
       }
         if (filetype("$del") == "file"){
             unlink($del);
             $this->ok("�������� ����� ������� ���������");
             exit;
      }
       else {
           remdir($del);
           $this->ok("�������� ���������� ������� ���������");
           exit;
       }
 }
 function mod() {
     global $cnf,$do;
         if (!empty($do)) {
             switch($do) {
                 case"upload":
                 $this->upload();
                 break;
                 case"mfile":
                 $this->mfile();
                 break;
                 case"type":
                 $this->type();
                 break;
                 case"out":
                 $this->out();
                 break;
                 case"search":
                 $this->search();
                 break;

             }
         }
         else {
             $this->lists();
         }
 }
  function sfile($DIR,$search){
	$handle = opendir ($DIR);
	while ($file = readdir ($handle)){
		if ($file == "." or $file == ".."){
            continue;
            }
		if (filetype("$DIR/$file") == "file"){
			if (preg_match("#\[([0-9]+)-([0-9]+)\]#", $search)){
				$fsize = filesize ("$DIR/$file");
				$frsize =preg_replace("#\[([0-9]+)-([0-9]+)\]#", "\\1", $search);
				$flsize =preg_replace("#\[([0-9]+)-([0-9]+)\]#", "\\2", $search);
                 $frsize=$frsize*1024;
                 $flsize=$flsize*1024;
				if ($fsize >= $frsize && $fsize <= $flsize){
				print "<tr><td>$file</td><td><a href=?DIR=$DIR>$DIR</a></td></tr>";
				}
			}
			if (strpos("$file", $search)){
                print "<tr><td>$file</td><td><a href=?DIR=$DIR>$DIR</a></td></tr>";
              }
            else if (strstr("$file", $search)){
                print "<tr><td>$file</td><td><a href=?DIR=$DIR>$DIR</a></td></tr>";
              }
		}
		else{
           if (strstr("$file", $search)){
                print "<tr><td><img src=kat.gif > $file</td><td><a href=?DIR=$DIR>$DIR</a></td></tr>";
              }
        $this->sfile("$DIR/$file", $search);
        }
	}
}
  function search() {
     global $cnf,$do;
     $sfile=$_POST['sfile'];
     print "<form method=POST >�����: <input type=text name=sfile ><input type=submit value=������ ></form>
             <font style='font-size:11px;'>( ��� ������ �� ��������� ������� ����������� ��������� ���������: [��-��] ,��� ��-��������� ������,��-��������,� ��)</font>";
        if (isset($sfile) && !empty($sfile)) {
        print "<br><br><table width=90% align=center border=1><tr><td><b>����</b></td><td><b>������</b></td></td>";
          $this->sfile($cnf['path'],$sfile);
    }
 }
 function type() {
     global $cnf,$do;
      print "<center><b>�������� �����</b></center><br>";
      $ntype=$_POST['ntype'];
       if (isset($ntype)) {
              $ntype=explode("\r\n",$ntype);
              $fp=fopen("type.dat","w");
              $style="";
              for ($i=0;$i<count($ntype);$i++) {
                  if (!empty($ntype[$i])) {
                       $stype .=$ntype[$i]."|";
                  }
              }
              $stype=substr($stype,0,-1);
                 fputs($fp,$stype);
                 fclose($fp);
                 $this->ok("����� ���� ������� ���������");
                  exit;
       }
      $fp=@file_get_contents('type.dat');
      $fp=explode('|',$fp);
      $type="";
      for($i=0;$i<count($fp);$i++) {
          $type .=trim($fp[$i])."\r\n";
      }
      print "
          <form method=POST>
          <table width=100%>
          <tr>
          <td align=center ><b>���� ������</b><br><font style='font-size:11px;'>(�� ������ ������� ����� ����������)</font>:<br> <textarea cols=30 rows=10 name=ntype >$type</textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='���������' class=button >
          </td>
          </table>
          </form> ";
 }
     function out() {
        unset($_SESSION['admin']);
       @session_destroy();
       print "<html><head><META HTTP-EQUIV='Refresh' content ='0;URL=index.php'></head></html>";
     }
   function chemod($chmod) {
     global $cnf;
       $nchmod=$_POST['nchmod'];
        if (!file_exists($chmod) && !is_dir($chmod))  {
           $this->ok("������: ���������� $chmod �� �������");
           exit;
       }
       if (!is_writable($chmod)) {
           $this->ok("������: ����������� ����� ������� � ����������");
           exit;
       }
         if (isset($nchmod) && !empty($nchmod)) {
              $file_name=preg_replace("#(.+)\/([^\/]+)$#","\\2",$chmod);
              $nchmod=trim($nchmod);
              if (chmod($chmod,base_convert($nchmod,8,10))) {
              $this->ok("����� �� $file_name ������� ��������");
              exit;
             }
             else {
             $this->ok("���������� ������� ����� �� $file_name");
              exit;
             }
         }
      print "<form method=POST >����� �����: <input type=text name=nchmod size=8 ><input type=submit value=��������� ></form><font style='font-size:11px;'>( ����� ������ ����� ��� 3 ����, �������� 755 )</font>";
 }
    function lists() {
     global $cnf,$do;
           $DIR=trim(@$_GET['DIR']);
           $rname=$_GET['rname'];
           $del=$_GET['del'];
           $mkdir=$_GET['mkdir'];
           $r=$_GET['r'];
           $chmod=$_GET['chmod'];
           $fcopy=$_GET['fcopy'];
       print "<center><b>�������</b></center><br>";
           if (!empty($rname)) {
               $this->rname($rname);
           }
           if (!empty($del)) {
               $this->deldir($del);
           }
           if (!empty($mkdir)) {
               $this->makedir($mkdir);
           }
           if (!empty($r)) {
               $this->rall($r);
           }
           if (!empty($chmod)) {
               $this->chemod($chmod);
           }
           if (!empty($fcopy)) {
               if (isset($_GET['done'])) {
                $this->fcopy($fcopy,'true');
              }
              else {

              $this->fcopy($fcopy);
             }
           }
         if (empty($DIR)) {
                $dir=$cnf['path'];
            }
         else {
                $dir=$DIR;
            }
        print "<form action=?do=$do method=GET >����������: <input type=text name=DIR value=\"$dir\" size=50><input type=submit value=�������></form>";
             if ($dir!=='' && !is_dir($dir)){
                  $this->ok('������: ���������� �� ����������');
                  exit;
             }
       $pr_dir=preg_replace("#\/([^\/]+)$#","",$dir);
        print " <center><a href=index.php?do=mfile&DIR=$dir >[������� ����] </a> <a href=index.php?do=$do&mkdir=$dir >[������� �����] </a> </center><br>
              <script>
              function del(url, fn) {
              var a = confirm(\"�� ������������� ������ ������� \"+fn+\"?\");
              if (a == true){
              window.location=url;
                  }
               }
             </script>
                <table align=center border=1 width=95%>
                <tr>
                <td colspan=5>
                <a href=?do=$do&DIR=$pr_dir>[�����]</a> <b>$dir</b>
                </td>
                </tr>
                <tr>
                <td><b>����/�����</b></td><td><b>������</b></td><td><b>������</b></td><td><b>�������</b></td><td><b>��������</b></td>
                </tr>";
         $handle = opendir ($dir);
          while ($file = readdir($handle)){
                if ($file == "." or $file == ".."){
                                  continue;
                               }
                if (filetype("$dir/$file") !== "file"){
                       $size=0;
                       $size=size_dir("$dir/$file",$size);
                       $size=round($size/1024, 2);
					print "<tr><td><img src=kat.gif > $file</td><td>$size ��</td><td>".date("d.m.Y", filectime("$dir/$file"))."</td><td>".date("d.m.Y", filemtime("$dir/$file"))."</td><td align=center>
              <select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"navSelect\">
              <option selected>����� ��������</option>
              <option value=\"?do=$do&DIR=$dir&rname=$dir/$file\">�������������</option>
              <option value='javascript:del(\"?do=$do&del=$dir/$file\", \"$file\")'>�������</option>
              <option value=\"?do=$do&DIR=$dir/$file\">�������</option>
              <option value=\"?do=upload&DIR=$dir/$file\">��������� ����</option>
              <option value=\"?do=$do&chmod=$dir/$file&DIR=$dir\">������� �����</option>
              </select>
              </td></tr>";
					}
                 }
          $handle = opendir ($dir);
		  while ($file = readdir($handle)){
                if ($file == "." or $file == ".."){
                                  continue;
                                 }
                    if (filetype("$dir/$file") == "file"){
					print "<tr><td>$file</td><td>".round(filesize("$dir/$file")/1024, 2)." ��</td><td>".date("d.m.Y", filectime("$dir/$file"))."</td><td>".date("d.m.Y", filemtime("$dir/$file"))."</td><td align=center>
              <select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"navSelect\">
              <option selected>����� ��������</option>
              <option value=\"?do=$do&DIR=$dir&rname=$dir/$file\">�������������</option>
              <option value='javascript:del(\"?do=$do&del=$dir/$file\", \"$file\")'>�������</option>
              <option value=\"?do=$do&fcopy=$dir/$file&DIR=$dir&done\">�����������</option>
              <option value=\"?do=$do&fcopy=$dir/$file&DIR=$dir\">����������</option>
              <option value=\"?do=$do&chmod=$dir/$file&DIR=$dir\">������� �����</option>
              <option value=\"?do=$do&r=$dir/$file&DIR=$dir\">�������������</option>
              </select></td></tr>";
					}
                  }
           closedir($handle);
                    print "</table>";
           
  }

}

?>
