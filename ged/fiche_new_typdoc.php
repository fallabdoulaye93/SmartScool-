<?php require_once('../Connections/connexion.php'); include('../restriction_page.php');?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO TYPEDOCADMIN (IDTYPEDOCADMIN, LIBELLE, CONTENU, IDETABLISSEMENT, IDMODELE_DOC) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDTYPEDOCADMIN'], "int"),
                       GetSQLValueString($_POST['LIBELLE'], "text"),
                       GetSQLValueString($_POST['CONTENU'], "text"),
                       GetSQLValueString($_POST['IDETABLISSEMENT'], "int"),
                       GetSQLValueString($_POST['IDMODELE_DOC'], "int"));

  mysql_select_db($database_connexion, $connexion);
  $Result1 = mysql_query($insertSQL, $connexion) or die(mysql_error());

  $insertGoTo = "page_type_doc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>nouveau type doc</title>
<script src="../src/fonctions.js" type="text/javascript"></script>
<script type="text/javascript" src="../tiny_mce/jscripts/tiny_mce/tiny_mce.js"></script><script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr align="left" valign="top">
    <td class="Titre">CREATION D'UN NOUVEAU TYPE DE DOCUMENT</td>
  </tr>
  <tr align="left" valign="top">
    <td height="2" background="../images/im_lign.jpg"></td>
  </tr>
  <tr align="left" valign="top">
    <td>
      <form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="75%"><table width="60%" align="center">
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="titretablo"><span class="nomEntrepr">LIBELLE</span>:</td>
                <td bgcolor="#F3F3F3"><span id="sprytextfield1">
                  <input name="LIBELLE" type="text" class="form3" value="" size="32" />
                  <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></td>
</tr>
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr">CONTENU:</td>
                <td bgcolor="#F3F3F3"><label for="CONTENU"></label>
                  <textarea name="CONTENU" cols="45" rows="5" class="form3" id="CONTENU"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" bgcolor="#F3F3F3">&nbsp;</td>
                <td bgcolor="#F3F3F3"><input name="button" type="image" id="button" value="Envoyer" src="../images/bt_creer.png" /></td>
              </tr>
            </table>
              <input name="IDTYPEDOCADMIN" type="hidden" value="" />
              <input name="IDETABLISSEMENT" type="hidden" id="IDETABLISSEMENT" value="<?php echo $_SESSION['ETABLISSEMENT']; ?>" />
              <input type="hidden" name="IDMODELE_DOC" value="0" />
              <input type="hidden" name="MM_insert" value="form2" />
              <p></p>
              <table width="60%" align="center">
                <tr valign="baseline"> </tr>
            </table></td>
            <td width="25%"><fieldset>
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
        </table>
        <table width="60%" align="center">
        <tr valign="baseline">          </tr>
        </table>
    </form></td>
  </tr>
</table>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>

