<?php
require_once('../Connections/connexion.php'); include('../restriction_page.php'); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE TYPEDOCADMIN SET LIBELLE=%s, CONTENU=%s, IDETABLISSEMENT=%s, IDMODELE_DOC=%s WHERE IDTYPEDOCADMIN=%s",
                       GetSQLValueString($_POST['LIBELLE'], "text"),
                       GetSQLValueString($_POST['CONTENU'], "text"),
                       GetSQLValueString($_POST['IDETABLISSEMENT'], "int"),
                       GetSQLValueString($_POST['IDMODELE_DOC'], "int"),
                       GetSQLValueString($_POST['IDTYPEDOCADMIN'], "int"));

  mysql_select_db($database_connexion, $connexion);
  $Result1 = mysql_query($updateSQL, $connexion) or die(mysql_error());

  $updateGoTo = "page_type_doc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rq_typ_doc = "-1";
if (isset($_GET['IDTYPEDOC'])) {
  $colname_rq_typ_doc = $_GET['IDTYPEDOC'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_typ_doc = sprintf("SELECT * FROM TYPEDOCADMIN WHERE IDTYPEDOCADMIN = %s", GetSQLValueString($colname_rq_typ_doc, "int"));
$rq_typ_doc = mysql_query($query_rq_typ_doc, $connexion) or die(mysql_error());
$row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc);
$totalRows_rq_typ_doc = mysql_num_rows($rq_typ_doc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<script src="../src/fonctions.js" type="text/javascript"></script>
<script type="text/javascript" src="../tiny_mce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr align="left" valign="top">
    <td width="90%" class="Titre">MODIFICATION  type de document</td>
    <td width="10%" class="Titre"><img src="../images/bt_nouveau.png" width="106" height="27" /></td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="2"><img src="../images/im_lign.jpg" width="950" height="2" /></td>
  </tr>
  <tr align="left" valign="top">
    <td height="166" colspan="2"><table width="100%" border="0" cellspacing="4" cellpadding="0">
      <tr align="left" valign="top">
        <td width="71%"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="100%" align="center">
              <tr valign="baseline">
                <td nowrap="nowrap" align="right"><span class="titretablo">LIBELLE</span>:</td>
                <td class="textBrute"><input type="text" name="LIBELLE" value="<?php echo htmlentities($row_rq_typ_doc['LIBELLE'], ENT_COMPAT, 'utf-8'); ?>" size="90" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" class="titretablo">CONTENU:</td>
                <td><textarea name="CONTENU" cols="100" rows="5" class="textBrute"><?php echo htmlentities($row_rq_typ_doc['CONTENU'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><input name="button" type="image" id="button" value="Envoyer" src="../images/bt_modifier.png" /></td>
              </tr>
            </table>
            <input type="hidden" name="IDTYPEDOCADMIN" value="<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']; ?>" />
            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo htmlentities($row_rq_typ_doc['IDETABLISSEMENT'], ENT_COMPAT, 'utf-8'); ?>" />
            <input type="hidden" name="IDMODELE_DOC" value="<?php echo htmlentities($row_rq_typ_doc['IDMODELE_DOC'], ENT_COMPAT, 'utf-8'); ?>" />
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="IDTYPEDOCADMIN" value="<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']; ?>" />
        </form></td>
        <td width="29%"><fieldset>
          <legend class="Titre">LEGENDE
          </legend><table width="100%" height="244" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3F3F3">
            <tr>
              <td width="46%" class="titretablo">A INSERER</td>
              <td width="54%" class="titretablo">DESCRIPTION</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[IDENTITE_DIRECTEUR]</td>
              <td>Prénoms et nom du directeur</td>
            </tr>
            <tr>
              <td align="right" valign="top" class="textNormalJustifier">[ETABLISSEMENT]</td>
              <td>Nom de l'établissement</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[VILLE]</td>
              <td>Ville</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[IDENTITE_ELEVE]</td>
              <td>Prénoms et nom de l'élève</td>
            </tr>
            <tr>
              <td><span class="textNormalJustifier">[DATENAISSANCE</span>]</td>
              <td>Date de naissance</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[DATE_INSCRIPTION]</td>
              <td>Date l'inscription de l'élève ou étudiant</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[CLASSE]</td>
              <td>Classe de l'individu</td>
            </tr>
            <tr>
              <td class="textNormalJustifier">[DATE_AUJOURDHUI]</td>
              <td class="textNormalJustifier">Date du jour</td>
            </tr>
          </table>
        </fieldset></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rq_typ_doc);
?>
