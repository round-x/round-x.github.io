<?

include "config.php";
include "inc.php";
include "class.php";
@session_start();
$do=$_GET['do'];
$adm=new main();
$adm->auth();


 print "
           <html>
           <head>
           <title>���������� license v.1.1</title>
         <META NAME=\"Generator\" CONTENT=\"license v.1.11 [ http://mit-home.nov.ru ]\">
           <LINK href=\"style.css\" type=text/css rel=stylesheet>
          </head>
            <body>
             <table width=\"98%\" border=\"0\" bordercolor=\"white\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
         <tr>
         <td valign=top width=5%></td>
         <td valign=top>
            <table border=\"0\" bordercolor=\"white\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=90%>
            <tr bgcolor=\"#016FAE\">
            <td style=\"BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid;\">
            <div style=\"margin-left:2;\"><font face=\"tahoma\" size=\"1\"><b>
            ����������:
            </b>
            </td>
            </tr>
            <tr bgcolor=\"FFFFFF\">
            <td style=\"BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 0px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid;\">
            <div style=\"margin-left:2;margin-top:2;margin-bottom:2;margin-right:2;\">
              <table width=100% cellpadding=\"0\" cellspacing=\"0\">
              <tr>
              <td width=16% class=tableleft valign=top >
              <font face=\"verdana\" size=\"1\">
             � <a href=index.php >�������</a><br>
             � <a href=index.php?do=upload >��������� ����</a><br>
             � <a href=index.php?do=mfile >������� ����</a><br>
             � <a href=index.php?do=type >�������� �����</a><br>
             � <a href=index.php?do=search >�����</a><br>
             � <a href='index.php?do=out' >�����</a><br>
             </font>
               </td>
               <td style='padding: 4px;'>

            ";
             
            $adm->mod();

print"

                </td>
                </table>
            </td>
            </tr>
            </table>
         </td>
         </tr>
         </table>
         </body>
         </html>";

?>