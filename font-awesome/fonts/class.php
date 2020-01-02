<?
class main {
  function auth() {
     global $cnf;
     if (!isset($_SESSION['admin'])) {
         $pass=$_POST['pass'];
             if (isset($pass) && empty($pass)) {
                  die("Ошибка: Нужно заполнить все поля");
             }

             if (isset($pass) && !empty($pass)) {

                  if ($pass==$cnf['pass']) {
                       $_SESSION['admin']=$cnf['pass'];
                        print "<html><head><META HTTP-EQUIV='Refresh' content ='0;'></head></html>";
                  }
                  else {
                      die("Ошибка: Неверный Логин или Пароль!");
                  }
           }
             print "
         <html>
         <head>
         <title>Авторизация</title>
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
            Авторизация:
            </b>
            </td>
            </tr>
            <tr bgcolor=\"FFFFFF\">
            <td style=\"BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 0px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid;\">
            <div style=\"margin-left:2;margin-top:2;margin-bottom:2;margin-right:2;\"><font face=\"verdana\" size=\"1\">
              <table cellpadding=\"0\" cellspacing=\"0\" width=100%>
              <tr>
              <td><font face=\"verdana\" size=\"1\"><b>Введите Пароль: </b></font></td><td><input type=password name='pass'></td>
              </table> <br>
            <center><input type=submit value='Принять' class='button' ></center>
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
        print "<center><b>Загрузка файла</b></center><br>";
        if (isset($dir) && empty($dir) || isset($file) && empty($file)) {
            $this->ok('Ошибка: Все поля нужно заполнить');
            exit;
        }
       if (isset($dir) && !empty($dir) && !is_dir($dir))  {
            $this->ok('Ошибка: Директория не существует');
            exit;
        }
       if (isset($dir) && !empty($dir) && !is_writable($dir)){
            $this->ok('Ошибка: Отсутствуют права доступа к директории');
            exit;
        }
        if (isset($dir) && !empty($dir) || isset($file) && !empty($file)) {
              $file_name = $_FILES["FILE"]["name"];
              $dir=trim($dir);
               if (@move_uploaded_file($file, "$dir/$file_name")) {
                    chmod("$dir/$file_name",0755);
                    $link=preg_replace("#(.*)$chf[path]\/(.+)#i","\\2",$dir);

                    $link="http://".$_SERVER['HTTP_HOST']."/".$link."/".$file_name;
                    $this->ok("Файл: $file_name успешно загружен,Ссылка: $link");
                    exit;

             }
               else {
                    $this->ok("Ошибка: невозможно загрузить файл: $file_name");
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
            <td width=25%><b>Директория загрузки:</b></td><td> <input type=text name='DIR' value=$DIR size=37> </td>
            <tr>
            <td width=25%> <b>Файл:</b></td><td> <input type=file name='FILE' size=40></td>
            </tr>
            </table>
          </tr>
          <tr>
          <td align=center>
          <input type=submit value='Загрузить' class=button >
          </td>
          </table>
          </form>";
   }
    function ok($ok) {

           print "
           <table width=50% align=center style='border:1px solid #000000'>
           <tr>
           <td align=center><b>$ok<b><br><a href='index.php' >[На главную]</a></td>
           </tr>
           </table>";

   }
     function mfile() {
        global $cnf;
        $DIR=$_GET['DIR'];
        $dir=$_POST['dir'];
        $file_name=$_POST['file_name'];
        $ftext=$_POST['ftext'];
        print "<center><b>Создание файла</b></center><br>";
        if (empty($DIR)) {
            $DIR=$cnf['path'];
        }
        if (isset ($dir) && $dir=='' || isset ($file_name) && $file_name=='' ) {
            $this->ok('Ошибка: нужно заполнить поля: "Директория" и "Название файла"');
            exit;
        }
        if (isset ($file_name) && preg_match("#[\/\:\*\?\"<>\|]#", $file_name)) {
            $this->ok('Ошибка: имя не должно содержать / \ : * ? \" <> | ');
            exit;
        }
        if (isset ($dir) && !is_dir($dir))  {
            $this->ok('Ошибка: Директория не существует');
            exit;
        }
        if (isset ($dir) && !is_writable($dir)){
            $this->ok('Ошибка: Отсутствуют права доступа к директории');
            exit;
        }
        if (isset ($dir) && isset ($file_name) && file_exists("$dir/$file_name") && $dir!=='' && $file_name!=='') {
            $this->ok('Ошибка: Такой файл уже существует');
            exit;
        }
        if (isset ($dir) && $dir!=='' || isset ($file_name) && $file_name!=='' ) {
        $asp=preg_replace("#(.*)\.#","",$file_name);
        $asp=strtolower($asp);
        $fp=@file_get_contents('type.dat');
        $fp=explode('|',$fp);
         if (!in_array($asp,$fp)) {
               $this->ok('Ошибка: Тип файла не поддерживается');
               exit;
             }

           $op = fopen ("$dir/$file_name", "w");
					fputs ($op,$ftext);
					fclose ($op);
               $this->ok("Файл: $dir/$file_name успешно создан");
               exit;
        }
        print "
          <form method=POST>
          <table width=100%>
          <tr>
          <td>
            <table width=100%>
            <tr>
            <td width=20%><b>Директория:</td><td><input type=text name='dir' value=$DIR size=40 > </td>
            <tr>
            <td width=20%><b>Название файла:</td><td> <input type=text name='file_name' size=40> </td>
            </table>
          </td>
          </tr>
          <tr>
          <td align=center ><b>Содержание файла:<br> <textarea cols=50 rows=10 name=ftext ></textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='Создать' class=button >
          </td>
          </table>
          </form> ";
    }
 function rall($r) {
      global $cnf,$do;
            print "<center><b>Редактор</b></center><br>";
            
           if (!file_exists($r)){
               $this->ok("Ошибка: Файл: $r не найден");
                exit;
           }
           if (!is_writable($r)) {
               $this->ok("Ошибка: Отсутствуют права доступа к директории");
                exit;
           }
           $asp=preg_replace("#(.*)\.#","",$r);
           $asp=strtolower($asp);
           $fp=@file_get_contents('type.dat');
           $fp=explode('|',$fp);
           if (!in_array($asp,$fp)) {
               $this->ok('Ошибка: Тип файла не поддерживается');
               exit;
             }

           $ftext=$_POST['ftext'];
              if (isset($ftext)) {
                     $ftext=stripslashes($ftext);
                     $fp=fopen($r,"w");
                         fputs($fp,$ftext);
                         fclose($fp);
                         $this->ok("Файл успешно изменён");
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
          <td align=center ><b>Содержание файла:<br> <textarea cols=55 rows=10 name=ftext >$frtext</textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='Принять' class=button >
          </td>
          </table>
          </form> ";

   }
   function rname($rname) {
     global $cnf,$do;
        if (!file_exists($rname) && !is_dir($rname))  {
             $this->ok("Ошибка: Файл/директория: $rname не найден");
             exit;
        }
        $dir=preg_replace("#\/([^\/]+)$#","",$rname);
        $nname=trim($_POST['nname']);
           if (isset($nname) && !empty($nname)) {
                if (!is_writable($rname) && !is_writable($dir)) {
                    $this->ok("Ошибка: Отсутствуют права доступа к файлу/директории");
                     exit;
                 }
                 if (preg_match("#[\/\:\*\?\"<>\|]#", $nname)) {
                    $this->ok('Ошибка: имя не должно содержать / \ : * ? \" <> | ');
                    exit;
                 }
                 rename($rname, "$dir/$nname");
                    $this->ok('Имя файла/директории успешно изменено');
                    exit;
              }
        $name=preg_replace("#(.*)\/#","",$rname);
        print "<form method=POST >Введите новое имя файла/директории: <input type=text name=nname value=\"$name\"><input type=submit value=Сохранить ></form>";
 }
 
 function makedir($mkdir) {
     global $cnf,$do;
       $name=$_POST['nname'];
       if (!is_dir($mkdir)) {
           $this->ok("Ошибка: Директория $mkdir не найдена");
           exit;
       }
       if (!is_writable($mkdir)) {
           $this->ok("Ошибка: Отсутствуют права доступа к директории");
           exit;
       }
         if (isset($name) && !empty($name)) {
         if (preg_match("#[\/\:\*\?\"<>\|]#", $name)) {
              $this->ok('Ошибка: имя не должно содержать / \ : * ? \" <> | ');
              exit;
              }
         if (is_dir("$mkdir/$name")){
              $this->ok('Ошибка: такая директория уже существует');
              exit;
            }
              mkdir("$mkdir/".trim($name)."");
              $this->ok("Директория: $mkdir/$name успешно создана");
              exit;
         }
      print "<form method=POST >Введите имя директории: <input type=text name=nname ><input type=submit value=Принять ></form>";
 }
  function fcopy($fcopy,$sost=false) {
     global $cnf,$do;
       $dir=$_POST['dir'];
       if (!file_exists($fcopy)) {
           $this->ok("Ошибка: Файл $fcopy не найдена");
           exit;
       }
       if (!is_writable($fcopy)) {
           $this->ok("Ошибка: Отсутствуют права доступа к директории");
           exit;
       }
         if (isset($dir) && !empty($dir)) {
         $file_name=preg_replace("#(.+)\/([^\/]+)$#","\\2",$fcopy);
         if (file_exists("$dir/$file_name")){
              $this->ok('Ошибка: такаой файл уже существует');
              exit;
            }
         if (!is_dir("$dir")){
              $this->ok('Ошибка: директория копирования не существует');
              exit;
            }
              copy($fcopy,"$dir/$file_name");
              if ($sost) {
              unlink($fcopy);
              $this->ok("Файл $file_name успешно перемещён");
               }
               else {
              $this->ok("Файл $file_name успешно копирован");
               }
              chmod("$dir/$file_name",0755);

              exit;
         }
      print "<form method=POST >Куда переместить/копировать: <input type=text name=dir ><input type=submit value=OK ></form>";
 }
  function deldir($del) {
     global $cnf,$do;
       if (!file_exists($del) && !is_dir($del))  {
             $this->ok("Ошибка: Файл/директория: $del не найден");
             exit;
        }
      if (!is_writable($del)) {
           $this->ok("Ошибка: Отсутствуют права доступа к файлу/директории");
           exit;
       }
         if (filetype("$del") == "file"){
             unlink($del);
             $this->ok("Удаление файла успешно завершено");
             exit;
      }
       else {
           remdir($del);
           $this->ok("Удаление директории успешно завершено");
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
     print "<form method=POST >Поиск: <input type=text name=sfile ><input type=submit value=Искать ></form>
             <font style='font-size:11px;'>( Для поиска по диопазону размера используйте следующий синтаксис: [от-до] ,где от-начальный размер,до-конечный,в кб)</font>";
        if (isset($sfile) && !empty($sfile)) {
        print "<br><br><table width=90% align=center border=1><tr><td><b>Файл</b></td><td><b>Ссылка</b></td></td>";
          $this->sfile($cnf['path'],$sfile);
    }
 }
 function type() {
     global $cnf,$do;
      print "<center><b>Редактор типов</b></center><br>";
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
                 $this->ok("Новые типы успешно добавлены");
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
          <td align=center ><b>Типы файлов</b><br><font style='font-size:11px;'>(На каждой строчке новое расширение)</font>:<br> <textarea cols=30 rows=10 name=ntype >$type</textarea></td>
          </tr>
          <td align=center>
          <input type=submit value='Сохранить' class=button >
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
           $this->ok("Ошибка: Директория $chmod не найдена");
           exit;
       }
       if (!is_writable($chmod)) {
           $this->ok("Ошибка: Отсутствуют права доступа к директории");
           exit;
       }
         if (isset($nchmod) && !empty($nchmod)) {
              $file_name=preg_replace("#(.+)\/([^\/]+)$#","\\2",$chmod);
              $nchmod=trim($nchmod);
              if (chmod($chmod,base_convert($nchmod,8,10))) {
              $this->ok("Права на $file_name успешно изменены");
              exit;
             }
             else {
             $this->ok("Невозможно сменить права на $file_name");
              exit;
             }
         }
      print "<form method=POST >Новые права: <input type=text name=nchmod size=8 ><input type=submit value=Сохранить ></form><font style='font-size:11px;'>( Права должны иметь вид 3 цифр, например 755 )</font>";
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
       print "<center><b>Листинг</b></center><br>";
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
        print "<form action=?do=$do method=GET >Директория: <input type=text name=DIR value=\"$dir\" size=50><input type=submit value=Перейти></form>";
             if ($dir!=='' && !is_dir($dir)){
                  $this->ok('Ошибка: Директория не существует');
                  exit;
             }
       $pr_dir=preg_replace("#\/([^\/]+)$#","",$dir);
        print " <center><a href=index.php?do=mfile&DIR=$dir >[Создать файл] </a> <a href=index.php?do=$do&mkdir=$dir >[Создать папку] </a> </center><br>
              <script>
              function del(url, fn) {
              var a = confirm(\"Вы действительно хотите удалить \"+fn+\"?\");
              if (a == true){
              window.location=url;
                  }
               }
             </script>
                <table align=center border=1 width=95%>
                <tr>
                <td colspan=5>
                <a href=?do=$do&DIR=$pr_dir>[Назад]</a> <b>$dir</b>
                </td>
                </tr>
                <tr>
                <td><b>Файл/Папка</b></td><td><b>Размер</b></td><td><b>Создан</b></td><td><b>Изменен</b></td><td><b>Действия</b></td>
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
					print "<tr><td><img src=kat.gif > $file</td><td>$size кб</td><td>".date("d.m.Y", filectime("$dir/$file"))."</td><td>".date("d.m.Y", filemtime("$dir/$file"))."</td><td align=center>
              <select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"navSelect\">
              <option selected>Выбор действия</option>
              <option value=\"?do=$do&DIR=$dir&rname=$dir/$file\">Переименовать</option>
              <option value='javascript:del(\"?do=$do&del=$dir/$file\", \"$file\")'>Удалить</option>
              <option value=\"?do=$do&DIR=$dir/$file\">Перейти</option>
              <option value=\"?do=upload&DIR=$dir/$file\">Загрузить файл</option>
              <option value=\"?do=$do&chmod=$dir/$file&DIR=$dir\">Сменить Права</option>
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
					print "<tr><td>$file</td><td>".round(filesize("$dir/$file")/1024, 2)." кб</td><td>".date("d.m.Y", filectime("$dir/$file"))."</td><td>".date("d.m.Y", filemtime("$dir/$file"))."</td><td align=center>
              <select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"navSelect\">
              <option selected>Выбор действия</option>
              <option value=\"?do=$do&DIR=$dir&rname=$dir/$file\">Переименовать</option>
              <option value='javascript:del(\"?do=$do&del=$dir/$file\", \"$file\")'>Удалить</option>
              <option value=\"?do=$do&fcopy=$dir/$file&DIR=$dir&done\">Переместить</option>
              <option value=\"?do=$do&fcopy=$dir/$file&DIR=$dir\">Копировать</option>
              <option value=\"?do=$do&chmod=$dir/$file&DIR=$dir\">Сменить Права</option>
              <option value=\"?do=$do&r=$dir/$file&DIR=$dir\">Редактировать</option>
              </select></td></tr>";
					}
                  }
           closedir($handle);
                    print "</table>";
           
  }

}

?>
